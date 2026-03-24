# Projeto Horus

## Descrição
Este projeto é uma aplicação web em PHP que gerencia preferências, usuários, testemunhos e fornece um painel administrativo com funcionalidades de CRUD. O código está organizado em **model**, **Controllers** e **Layout** (HTML) seguindo o padrão MVC.

## Tecnologias Utilizadas
- PHP 7.x/8.x
- MySQL (ou MariaDB) para persistência de dados
- HTML5 e CSS3 para a interface
- JavaScript para interatividade básica

## Requisitos
- Servidor web com suporte a PHP (ex.: Apache, Nginx)
- Banco de dados MySQL
- Composer (opcional, caso haja dependências externas)

## Instalação
1. Clone o repositório ou copie os arquivos para o diretório do seu servidor web.
2. Crie um banco de dados e importe o script de criação de tabelas (arquivo `database.sql` se disponível).
3. Configure as credenciais de acesso ao banco editando o arquivo de configuração (ex.: `config.php`).
4. Defina as permissões corretas nas pastas de upload, se houver.
5. Acesse a aplicação via navegador, por exemplo: `http://localhost/Trabalho_final_horus/`.

## Estrutura de Pastas
```
Trabalho_final_horus/
├─ Controllers/          # Controladores MVC
├─ Layout/               # Arquivos HTML e recursos estáticos
│   └─ html/             # Templates de página
├─ model/                # Classes de modelo e acesso ao banco
├─ public/ (opcional)   # Arquivos públicos (css, js, imagens)
└─ README.md             # Este documento
```

## Uso
- **Administração**: Acesse `index_admin.html` para o painel administrativo.
- **Preferências**: Gerencie as preferências da aplicação via `Preferencias.php`.
- **Usuários**: CRUD de usuários está disponível em `Usuarios.php`.
- **Testemunhos**: Gerencie testemunhos em `Testemunhos.php`.

## Contribuição
1. Fork o repositório.
2. Crie uma branch para sua feature (`git checkout -b minha-feature`).
3. Faça commit das alterações (`git commit -m 'Descrição da mudança'`).
4. Envie para o seu fork (`git push origin minha-feature`).
5. Abra um Pull Request.

## Licença
Este projeto está licenciado sob a licença MIT. Consulte o arquivo `LICENSE` para mais detalhes.
