# 1001plates

## Brief 

1001Plates is a plateform website developped on Symfony 6.4. This project takes place in our back dev training course at Human Booster. 
As inspiration, I've used the following well-known websites : 
https://www.thefork.fr/
https://www.lyonresto.com/ 

Logo / colors / typo have been designed by Mara Ciora. I've also received some suggestions on UI/UX.
https://maraciora.com/

The application isn't finished at this stage. I will continue to work on it.

## Services

The website site is offering a listing of restaurant with relevant information. User can navigate and look for specified food type restaurant or searching by city. 
Restaurant manager can create a account and complete the needed information. 
The customer can contact directly the restaurant or use the booking service of the website.

## Website UI

### Controllers structure 

On the landing of the website, we can find the list of all the restaurant and 2 research forms (by name and city name). The main controller is the IndexController containing another route with the city name parameter. It includes a pagination from RestaurantRepository using KNP paginator. I wanted to use the symfony paginator on the admin back office. 
RestaurantController possess 2 routes. One is the result of the form research by name and the other one the main page of each restaurant. 
The FoodTypeController is referring on the listing by food category with 2 routes if the cityName is defined or not. 
You can also find the NewsletterController including the newsletter form. I've used an API spam checker : https://api.apilayer.com for checking the entering emails. 
On security side, there is the SecurityController with the login/logout routes. 
A resetPasswordController has been implemented also using the Symfony documentation: https://symfony.com/doc/4.x/security/reset_password.html. I've translated most of the texts in French.


## BackOffice

### Restaurant backoffice

I've spent a lot of time in developping this back office where the restaurant user may modify the information and delete the account. The RestaurantPrivateController is maybe too heavy and could be dispatched. I've developped the different forms one by one and tested them as well at first.


## Security 

### Voters

I've used 2 voters in restaurant private space one based on restaurant id and the other one based on menu id. 



## Issues

### EventListener on Delete restaurant 
It seems that the eventListener is not triggered when a restaurant is deleted.



## Features missing 

### Create/edit form for OpeningDays in private restaurant space

### Private space for customer

### Backoffice for Admin with EasyAdmin

### Booking service

### Exceptions and error managements
Url parameter name in restaurant controller, it should be also by city or id in case of restaurant with the same name.

### API service


## Configuration

Free account to https://api.apilayer.com is needed with API key if you want to use this spam checker.
