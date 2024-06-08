# Technical Task for MANUAL

## Task

You are tasked with architecting the backend-side of this functionality for the Erectile Dysfunction (ED) category. You are asked to provide the following:
- An API that returns the questionnaire, which includes all the questions and answers (plus any conditional restrictions for when questions should appear). Frontend engineers will use this API to render the complete questionnaire flow to the customer.
- An API that accepts the questionnaire answers and returns an array of the recommended products that the customer can purchase.
- A simple admin panel for the medical team to be able to input additional questions or alter the existing questions/recommendation logic.

## Application

This project is built using Symfony and cloned initially from the `symfony-docker` project. Doctrine has been set up as the ORM and the project is containerised using Docker. PHPUnit is the testing framework, and the EasyAdmin symfony bundle was used to create the admin system. 

There is an OpenAPI spec available in `openapi/spec.yaml` for the API.

## Development Environment

This was built on MacOS but should have no trouble running on any Unix system through Docker. It should work fine on Windows too, but I know Docker can sometimes be finnicky with Windows. A Makefile is included for convenience and has some useful commands. From within the directory:

Launch the application: `make start`  
Migrate the database to the latest version: `make migrate`  
Preload the database with sample data: `make fixtures`  
Run the test suite: `make test`  
View the Application logs: `make-logs`  
View the Docker logs: `make docker-logs`  
Enter the container: `make enter`  
Run a linting check: `make lint`

Once running API is available at `http://localhost` and the admin interface is located at `https://localhost/admin`.

## Next Steps

I spent roughly a work day on this tech task before calling it quits. Admittedly, the first chunk of that was reaquainting myself with Symfony and Doctrine, as it has been some years since we last tangoed together.

*Below I've listed the next steps I'd like to have taken for this project roughly in order of priority.*

### Admin
I didn't spend as much time on the Admin section as I wanted to so there's quite a bit of work there at the minute. It's fully functional in that it meets requirements, but it's not a joy to use.
- Being able to edit a questionnaire, it's questions and their answers dynamically on one page was the hope.

It also doesn't have any user management yet set up on it, which would be essential before going to prod.

### Testing

More comprehensive test coverage. At the minute, only essential functionality has been tested to ensure that more complex decision making functions correctly, but I'd be happier with a complete integration test for an entire flow submission flow in place. 
- A Postman Collection could be useful for this too.

### Getting Production Ready
- The API needs some sort of authentication mechanism. I'd probably just go for something simple like an Auth Key system as an initial iteration.
- Containers are not yet ready for production (see `symfony-docker` repo on how to do this)

### Data Models
The data models possibly need a refactor. I wanted to prioritise completing known, specific requirements first. Over-engineering a clever solution can come later, when there's more time to pay down the tech debt.
- Initially I was looking at using UUIDs, but the Symfony docs recommend against that. For now I went with standard auto-incrementing IDs, but with a little more time and research I'd explore some other options.
- Products could do with being split into a 'dosage' and a 'brand' field, instead of a generic 'name'. 'brand' can then be managed as an enum, or potentially even it's own model if there was a need for it.
- There could be a future need for more complex routing behaviour through the survey, rather than simply showing or hiding questions based on previous answers given. 
  - Depending on the long-term vision for what this project could be and how many users it might have, a scripting engine might be necessary to get really complex flows working.

The Data Fixtures could be broken out into a separate files for a more manageable structure.

### Validation
- I'd like to make use of Symfony's built-in validation mechanisms by setting up some DTO models for use when decoding the request body for the submission. 
  - Ultimately I thought it was faster to do the validation quick and dirty manually, with tests to verify the behaviour. Short term tech-debt with a view of paying that back later.

### OpenAPI Spec
- Set up the `swagger-php` library so that API spec can be defined in code as annotations/attributes and then automatically built into an OpenAPI spec through tooling, so there's only a single source of truth to manage.
- It'd also be good to get the OpenAPI spec hosted alongside the actual application itself.
