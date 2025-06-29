# ⚒️Setup do projeto

Com a configuracao actual do projeto este provavelmente nao vai funcionar como deve ser

## 🗂️ Configurando Paths (caminhos)

No diretorio `C:\xampp\htdocs`, o meu o projeto esta em `\phpmodule\library-manager-php`. Para que projeto funcione na sua maquina tera que modificar o `BASE_URL` dentro do `config.php`

```php
<?php
define(
    'BASE_URL',
    'caminho/do/teu/projeto'
);
//... resto do codigo
?>
```

Ou seja se o teu projeto esta em `C:\xampp\htdocs\PROJETOS_PHP\library-manager-php`, entao o seu `config.php` sera:

```php
<?php
define(
    'BASE_URL',
    '/PROJETOS_PHP/library-manager-php'
);
//... resto do codigo
?>
```

## 🛢️ Conexão com a Base de Dados

- Certifique-se de configurar corretamente as credenciais de acesso à base de dados no arquivo `config.php`:

  ```php
  <?php
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'nome_da_base');
  define('DB_USER', 'usuario');
  define('DB_PASS', 'senha');
  //... resto do código
  ?>
  ```

- Crie a base de dados e as tabelas necessárias utilizando os scripts SQL fornecidos no ficheiro `db_schema.sql`.
- Verifique se o servidor MySQL está em execução antes de iniciar o projeto.

---

## 📝 TODO – Sistema de Gestão Bibliotecário

### 🔐 Login e Administração

- [x] Criar tabelas SQL (`users`, `roles`, etc.)
- [x] Página de Login (`/auth/login`)

  - [x] Lógica de autenticação (verificar `username` + `password_hash`)
  - [x] Gestão de sessão e redirecionamento por função (admin/user)

- [x] Página de Administração (Dashboard)

  - [x] Mostrar overview da de actividades (emprestimos de livros) e quantidades

- [x] Exibir resumo geral: total de livros, autores, empréstimos, etc.

---

### 👥 Gestão de Utilizadores

- [x] Formulário para adicionar utilizador
 <!-- Admin -->
- [x] Formulário para editar utilizador
- [x] Link para eliminar utilizador
- [x] Listagem de utilizadores

---

### 📚 Gestão de Livros

- [x] Formulário para adicionar livro
- [x] Pagina para listar livros
- [x] Formulário para editar livro
<!--- [ ] Formulário para emprestar livro a utilizador   Not necessary-->
- [x] Listar livros emprestados com datas e utilizadores
- [x] Link para devolver livro (actualizar status)

---

### ✍️ Gestão de Autores

- [x] Formulário para adicionar autor
- [x] Formulário para editar autor
- [x] Link para eliminar autor
- [x] Página para listar livros por autor
