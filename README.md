# cli_front
Repositórios com exemplos de front-end.

## Configuração do banco de dados (MariaDB)

As migrações e seeds utilizam [PHP ActiveRecord](https://www.phpactiverecord.org/) e agora estão configuradas para se conectar a um banco MariaDB/MySQL.

1. Instale as dependências do projeto (Composer) e crie um banco de dados vazio, por exemplo `clinic_app`.
2. Defina as variáveis de ambiente antes de executar migrações/seeds conforme necessário:

   ```bash
   export DB_NAME="clinic_app"
   export DB_USER="root"
   export DB_PASSWORD="<sua_senha>"  # deixe vazio se não houver senha
   export DB_HOST="localhost"
   export DB_PORT="3306"
   export APP_ENV="development"
   ```

3. O arquivo `db/config/database.php` monta automaticamente a string de conexão `mysql://` usando essas variáveis e registra a conexão padrão no `ConnectionManager`.
4. Após configurar, execute as migrações e então o seed `db/seeds/seed_data.php`.
