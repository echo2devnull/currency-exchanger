# Fee Calculator
This application calculates fees based on provided input data. It utilizes Docker and Docker Compose for easy setup and execution.

## Prerequisites
Before running the application, please ensure that you have Docker and Docker Compose installed on your system. You can verify if they are installed by running the following commands in your terminal:

```bash
docker --version
docker-compose --version
```

If both commands display version information, Docker and Docker Compose are already installed on your system. Otherwise, you can follow the installation instructions below:

* [Install Docker](https://docs.docker.com/engine/install/)
* [Install Docker Compose](https://docs.docker.com/compose/install/)

## Getting Started
1. Clone this repository to your local machine.
2. Navigate to the project directory.

## Setting up Environment
1. Install dependencies by running `composer intsall`.
2. Create a `local.env` file based on `local.env.dist` provided in the project root.
3. Update the value for the `EXCHANGE_RATES_API_NET_API_KEY` variable in the local.env file with your actual API key.  If you don't have an API key, you can use the demo key provided below:
```plaintext
EXCHANGE_RATES_API_NET_API_KEY=pz66lkXU9uEsIB5a 
```

## Running the Application
To run the application, execute the following command in your terminal:

```bash
docker-compose run fee-calculator
```
This command will start the application and perform the fee calculation based on the provided input.

## Running Unit Tests
To run the unit tests, execute the following command:

```bash
docker-compose run phpunit
```
This command will run all unit tests and display the results in your terminal.
