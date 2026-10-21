# SENN AI-X — Gestão Logística

## Requisitos
- XAMPP com Apache e MySQL
- Navegador e VS Code

## Instalação
1. Copie a pasta `moduloA_SENN_AIX` para `C:\xampp\htdocs\`.
2. Abra o XAMPP e inicie Apache e MySQL.
3. Entre em `http://localhost/phpmyadmin`.
4. Importe o arquivo `database.sql`.
5. Abra `http://localhost/moduloA_SENN_AIX/`.

## Acesso inicial
O projeto inicial não implementa login ainda. A tela é um protótipo funcional do painel e cadastro de entregas/veículos. Implemente autenticação antes de usar com dados reais.

## Tecnologias
- PHP com PDO para acesso parametrizado ao MySQL.
- MySQL para persistência.
- HTML/CSS responsivo.
- Leaflet/OpenStreetMap para visualização de mapa.

## Roteirização
A primeira versão ordena/visualiza entregas e permite evoluir para um algoritmo VRP. A otimização real precisa considerar coordenadas, capacidade, janelas de entrega e distância/tempo de deslocamento; o protótipo não afirma otimização real.

## IA
A IA não está conectada nesta versão inicial. Para cumprir os requisitos de previsão, risco de atraso e análise inteligente, configure posteriormente uma API/modelo e mantenha a chave em variável de ambiente, nunca no JavaScript do navegador.

## Próximas etapas
1. Autenticação segura e perfis.
2. CRUD completo de veículos, motoristas e entregas.
3. Importação CSV e comprovante de entrega.
4. Integração com API de IA e serviço de roteamento.
5. Alertas, exportação de relatórios e testes.
