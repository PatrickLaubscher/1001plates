# 1001plates

## Brief 

1001Plates is a plateform website developped on Symfony 6.4. This project takes place in our back dev training course at Human Booster. 
As inspiration, I've used the following well-known websites : 
https://www.thefork.fr/
https://www.lyonresto.com/ 

Logo / colors / typo by Mara Ciora. 
https://maraciora.com/

The application isn't finished at this stage. I will continue to work on it.

## Services

The website site is offering a listing of restaurant with relevant information. User can navigate and look for specified food type restaurant or searching by city. 
Restaurant manager can create a account and complete the needed information. 
The customer can contact directly the restaurant or use the booking service of the website.
There is also an API who provides the list of the restaurant.

## Website UI

### Controllers structure 

On the landing page of the website, we can find the list of all the restaurant and 2 research forms (by name and city name). The main controller is the IndexController containing another route with the city name parameter. It includes a pagination from RestaurantRepository using KNP paginator. I wanted to use the symfony paginator on the admin back office. 
RestaurantController possess 2 routes. One is the result of the form research by name and the other one the main page of each restaurant. 
The FoodTypeController is referring on the listing by food category with 2 routes if the cityName is defined or not. 
You can also find the NewsletterController including the newsletter form. I've used an API spam checker : https://api.apilayer.com for checking the entering emails. 
On security side, there is the SecurityController with the login/logout routes. 
A resetPasswordController has been implemented also using the Symfony documentation: https://symfony.com/doc/4.x/security/reset_password.html. I've translated most of the texts in French.


## BackOffice

### Restaurant backoffice

I've spent a lot of time in developping this back office where the restaurant user may modify the information and delete the account. The RestaurantPrivateController is maybe too heavy and could be maybe dispatched. I've developped the different forms one by one and tested them as well at first.
An personnalized event is defined when a restaurant delete its account. The listener deletes the upload's pictures of the account. 


## Security 


### User

3 types of user are defined : admin, restaurant and customer with specific roles.


### Voters

I've used 2 voters in restaurant private space one based on restaurant id and the other one based on menu id. 



## Issues

The API for checking spam may be more configuration to be efficient. I've conduct several test but I think another api check may be more suitable. 
I didn't have the time to create the form for the openin day feature. It's working on the view side with binary conversion from integer. I have an idea for the create form but didn't try to do it. 
I aslo tried to create an API exception for connection to the API but I'm not sure it's working well. Exceptions are on of the part I would like to learn more about. Managing error is quite challenging but interesting too.


## Features missing 

### Create/edit form for OpeningDays in private restaurant space

### Private space for customer

### Backoffice for Admin with EasyAdmin

### Booking service

### Exceptions and error managements
Url parameter name in restaurant controller, it should be also by city or id in case of restaurant with the same name.

### API service token


## Configuration

Free account to https://api.apilayer.com is needed with API key if you want to use this spam checker.
