# Einzelwerk test

## Prerequisites
Ensure you have the following installed before proceeding:
- PHP
- Composer
- Docker
- Make (for running `make` commands)


## Installation Steps

1. **Clone the repository**
   ```sh
   git clone git@github.com:Serengiy/einzelwerk-test.git
   ```

2. **Copy the environment file and configure it**
   ```sh
   cp .env.example .env
   ```

3. **Then, fill in the following fields in .env:**
    ```dotenv
    DADATA_TOKEN=
    DADATA_SECRET=
    DADATA_TIMEOUT=
    DADATA_VERSION=
    DADATA_SUGGESTIONS_API=
    ```

4. **Install dependencies and set up the project**   
    ```sh
   make install
   ```
   
5. **Access API Documentation**
    ```link
   http://localhost/docs
    ```
