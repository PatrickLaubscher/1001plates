# 1001plates

## Brief 

1001Plates is a plateform website developped on Symfony 6.4. This project takes place in our back dev training course at Human Booster. 
As inspiration, I've used the following well-known websites : 
https://www.thefork.fr/
https://www.lyonresto.com/ 

Logo / colors / typo have been designed by Mara Ciora. I've also received some suggestions on UI/UX.
https://maraciora.com/

The application isn't finished at this stage. I will continue to work on it.


## Website UI

### Controllers structure 

On the landing of the website, we can find the list of all the restaurant and 2 research forms (by name and city name). The main controller is the IndexController which another route with the city name parameter. 
RestaurantController possess 2 routes. One is the result of the form research by name and the other one the main page of each restaurant. 
The FoodTypeController is referring on the listing by food category with 2 routes if the cityName is defined or not. 
You can also find the NewsletterController including the newsletter form. I've used an API spam checker : https://api.apilayer.com for checking the entering emails. 
On security side, there is the SecurityController with the login/logout routes. 
A resetPasswordController has been implemented also. 



## Issues

### EventListener on Delete restaurant 
It seems that the eventListener is not triggered when a restaurant is deleted.



## Features missing 

### Private space for customer

### Backoffice for Admin with EasyAdmin

### Booking service

### Exceptions and error managements



## Configuration

Free account to https://api.apilayer.com is needed with API key if you want to use this spam checker.
