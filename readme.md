# Next.js Project : Travel Agency Management Application
This application allows travel agency administrators to plan and publish trips. It includes features for managing vehicles, drivers, stop points on routes, and trip details. The application uses Next.js for the front end, Spring Boot for the back end, and ScyllaDB for the database.

## Table of Contents
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Configuration](#configuration)
- [Main Features](#main-features)
- [Available Scripts](#available-scripts)
- [Learn More](#learn-more)
- [Contributing](#contributing)
- [License](#license)

## Getting Started

### Prerequisites
Make sure you have the following software installed on your machine:
- [Node.js](https://nodejs.org/)
- [yarn](https://yarnpkg.com/)
- [Next.js](https://nextjs.org/)
- [Java Development Kit (JDK)](https://www.oracle.com/java/technologies/javase-jdk11-downloads.html) for Spring Boot
- [ScyllaDB](https://www.scylladb.com/)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/IgorGreenIGM/travel-planning.git
   cd travel-planning
   ```
2. **Install Dependencies :**
   ```bash
   yarn install
   ```
### Configuration
3. **Set up the back end :**
   Ensure the ScyllaDB connection properties are correctly set in the `application.properties` file:
    ```properties
    spring.application.name=travel-planning
    server.servlet.context-path=/api
    spring.main.allow-circular-references=true
    springdoc.api-docs.path=/api-docs
    springdoc.swagger-ui.path=/doc
    spring.cassandra.port=9042
    spring.data.cassandra.username=your_username
    spring.data.cassandra.password=your_password
    spring.cassandra.request.timeout=2s
    spring.data.cassandra.contact-points=your-scylladb-host
    spring.data.cassandra.local-datacenter=your_datacenter
    spring.data.cassandra.keyspace-name=your_keyspace
    spring.cassandra.schema-action=CREATE_IF_NOT_EXISTS
    ```
4. **Run the Spring Boot server:**
    ```bash
   ./mvnw spring-boot:run
   ```
5. **Configure the api url in the config file:**
   ```js
    const api = axios.create({
    baseURL: 'http://127.0.0.1:8080/api', //Configure ypur baseURL
    headers: {
    'Content-Type': 'application/json'
    }
    });
   ```
6. **Run the project :**
    ```bash
    yarn run dev
    ```
   Open http://localhost:3000 with your browser to see the result


## Main Features
### Travel Management
- **Add Trips**: Administrators can add new trips by specifying:
  - Destination
  - Departure city
  - Stop points
  - Departure and arrival dates and times
  - Ticket prices

- **Edit Trips**: Existing trip information can be updated, including:
  - Route details
  - Stop points
  - Drivers
  - Associated vehicles

- **Delete Trips**: Trips can be deleted with options to:
  - Set a new start date
  - Cancel the trip entirely

### Stop Points
- **Define Stop Points**: Administrators can add multiple stop points to a trip. Each stop point includes:
  - City
  - Stop duration in minutes

- **Select Cities**: Available cities for stop points are retrieved dynamically and can be selected when planning trips.

### User Interface
- **Planning Dashboard**: The main interface displays a table listing all planned trips, including:
  - Trip name
  - Start and end dates
  - Trip status
- **Details Modal**: Clicking on a trip in the table opens a details modal to view and edit trip information, including stop points.
- **Notifications**: Notifications inform administrators of successful actions or errors.

## Available Scripts
In the project directory, you can run:

- **`npm run dev`**: Runs the app in development mode.
- **`npm run build`**: Builds the app for production.
- **`npm run start`**: Runs the built app in production mode.
- **`npm run export`**: Exports the app to static HTML.
- **`npm run lint`**: Lints the codebase for potential errors and code style issues.
- **`npm run format`**: Formats the codebase using Prettier.

## Learn More
To learn more about the technologies used in this project, take a look at the following resources:
- **[Next.js Documentation](https://nextjs.org/docs)**: Learn about Next.js, a React framework for building server-side rendered and static web applications.
- **[Spring Boot Documentation](https://docs.spring.io/spring-boot/docs/current/reference/htmlsingle/)**: Explore Spring Boot, a framework for creating stand-alone, production-grade Spring-based applications.
- **[ScyllaDB Documentation](https://docs.scylladb.com/)**: Get information on ScyllaDB, a high-performance NoSQL database designed for scalability and low latency.

## Contributing
Contributions are welcome! If you have any suggestions or improvements, feel free to open an issue or submit a pull request.
If you wish to contribute to this project, please follow these steps:
1. Fork this repository.
2. Clone your fork locally.
3. Create a branch for your feature (`git checkout -b my-feature-name`).
4. Commit your changes (`git commit -am 'Add feature name'`).
5. Push your branch (`git push origin my-feature-name`).
6. Create a new Pull Request.

## License
This project is licensed under the `MIT` License
