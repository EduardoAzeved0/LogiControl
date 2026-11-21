# LogiControl – Gerenciador Logístico

Projeto acadêmico desenvolvido para praticar desenvolvimento web com PHP, HTML, CSS, JavaScript e MySQL.

## Funcionalidades
- Painel inicial com resumo de cadastros e fretes recentes.
- Cadastro, listagem, edição e exclusão de produtos.
- Cadastro, listagem, edição e exclusão de endereços.
- Cadastro, listagem, edição e exclusão de transportadores.
- Geração de fretes relacionando transportador, origem, destino e vários produtos.
- Relatório diário de fretes, com opção de imprimir ou salvar em PDF pelo navegador.
- Layout responsivo com Bootstrap 5.

## Tecnologias
PHP 8+, MySQL/MariaDB, HTML5, CSS3, JavaScript, Bootstrap 5 e XAMPP.

## Como executar no XAMPP
1. Instale e abra o XAMPP.
2. Inicie os serviços Apache e MySQL.
3. Copie a pasta `LogiControl` para `C:\xampp\htdocs\`.
4. Acesse `http://localhost/phpmyadmin`.
5. Importe o arquivo `database/logistica.sql` (ou abra o SQL e execute seu conteúdo).
6. Confira usuário e senha em `config/database.php`. Na configuração padrão do XAMPP, o usuário é `root` e a senha fica vazia.
7. Abra `http://localhost/LogiControl/`.

## Fluxo recomendado para testar
1. Cadastre dois endereços (um para origem e outro para destino).
2. Cadastre um transportador.
3. Cadastre dois ou mais produtos.
4. Gere um frete e adicione vários produtos usando o botão “Adicionar produto”.
5. Consulte o frete na listagem.
6. Abra Relatórios, selecione a data e use “Imprimir / Salvar PDF”.

## Relacionamento principal
A tabela `fretes` guarda um transportador e os endereços de origem e destino. A tabela associativa `frete_produtos` permite relacionar vários produtos a um mesmo frete (relação muitos-para-muitos entre fretes e produtos). Assim, um transportador pode realizar fretes com vários produtos, atendendo ao requisito de um transportador transportar múltiplos itens.

## Versionamento com Git
Execute os comandos abaixo no terminal, dentro da pasta do projeto:

```bash
git init
git add .
git commit -m "chore: estrutura inicial do LogiControl"
git add .
git commit -m "feat: adiciona cadastros de produtos e enderecos"
git add .
git commit -m "feat: implementa cadastro de transportadores"
git add .
git commit -m "feat: cria geracao de fretes com varios produtos"
git add .
git commit -m "feat: adiciona relatorio diario de fretes"
```

Para publicar no GitHub, crie um repositório público vazio e conecte-o:

```bash
git branch -M main
git remote add origin https://github.com/SEU-USUARIO/LogiControl.git
git push -u origin main
```

Substitua `SEU-USUARIO` pelo seu usuário real do GitHub.

## Observações
- O relatório pode ser impresso ou salvo como PDF usando a função do navegador.
- O projeto é uma base didática. Antes de uso em produção, devem ser adicionados autenticação, controle de permissões, validação mais abrangente e regras de estoque.
