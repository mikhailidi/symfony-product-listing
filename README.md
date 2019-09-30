# symfony-product-listing

### How to install?
- Download this project `get clone https://github.com/mikhailidi/symfony-product-listing.git your-project-name`
- Navigate to this project `cd your-project-name`
- Run `docker-compose up -d` to install all necessary containers (P.S. You must have [Docker](https://www.docker.com/get-started) installed)
- Login into `shell` by taping `sh toolset.sh shell`
- Install all dependencies `$ composer install`
- Run `$ cp .env .env.local` to use local environment variable
- Open `.env.local` and replace `DATABASE_URL` variable with `DATABASE_URL=mysql://root:password@symfony-db:3306/product-listing`
- Run `$ bin/console doctrine:database:create` in order to create a local database
- Run database migrations `$ bin/console doctrine:migrations:migrate -n`
- Open `http://localhost/product/create` in your browser in order to create a new product.
