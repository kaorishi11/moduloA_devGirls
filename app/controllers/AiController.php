<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class AiController extends Controller {
    public function index() {
        Auth::require();
        $pdo = Database::pdo();
        $risky = $pdo->query("SELECT code,recipient,deadline FROM deliveries WHERE status<>'concluida' AND deadline < NOW() + INTERVAL 6 HOUR LIMIT 5")->fetchAll();
        $demand = $pdo->query("SELECT DATE(created_at) d, COUNT(*) c FROM deliveries WHERE created_at >= NOW() - INTERVAL 30 DAY GROUP BY DATE(created_at)")->fetchAll();
        $this->view('ai/index', compact('risky','demand'));
    }

    public function ask() {
        Auth::require();
        $question = trim($_POST['question'] ?? '');
        if (!$question) $this->json(['error' => 'Pergunta vazia'], 422);

        $endpoint = env('AI_API_ENDPOINT');
        $apiKey   = env('AI_API_KEY');

        if ($endpoint && $apiKey) {
            $payload = [
                'model' => env('AI_MODEL','gpt-4o-mini'),
                'messages' => [
                    ['role' => 'system', 'content' => 'Você é analista de logística da SENN AI-X. Responda em português, com foco em otimização de rotas, prazos, custos e riscos.'],
                    ['role' => 'user', 'content' => $question],
                ],
            ];
            $ch = curl_init($endpoint);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: Bearer ' . $apiKey],
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_TIMEOUT => 30,
            ]);
            $resp = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($resp, true);
            $answer = $data['choices'][0]['message']['content'] ?? null;
            if ($answer) return $this->json(['answer' => $answer, 'simulated' => false]);
        }

        // Fallback demonstrativo
        $answer = $this->simulateAnswer($question);
        $this->json(['answer' => $answer, 'simulated' => true]);
    }

    private function simulateAnswer(string $q): string {
        $pdo = Database::pdo();
        $pending = $pdo->query("SELECT COUNT(*) FROM deliveries WHERE status='pendente'")->fetchColumn();
        $late = $pdo->query("SELECT COUNT(*) FROM deliveries WHERE status='atrasada'")->fetchColumn();
        return "🤖 **[Resposta simulada — IA externa não configurada]**\n\n" .
               "Sobre: *{$q}*\n\n" .
               "• Entregas pendentes no sistema: {$pending}\n" .
               "• Entregas atrasadas: {$late}\n" .
               "• Sugestão: priorize as entregas com prioridade alta e prazo próximo, agrupe por região para reduzir km e redistribua veículos ociosos.";
    }
}