# projekt_webservice_vt22-christinejohanson
## DT173G Projektuppgift - Del 1 Webbtjänst/API
Repository för REST-api uppbyggd i php med tre olika api för anrop från webbplats 
till fiktik restaurang En halvfull bägare. 

Bookingapi för bokningar, menuapi för restaurangens meny samt adminapi för administration av webbplatsen.

**Länkar**

Länkar till API´n:

**Installation** 

Install.php inkluderar en konfigurationsfil med inställningar för 
databasen och install-filen installerar tabellerna i databasen. 

Tabellnamn

**Klasser och Metoder:**

menu

booking

**API och deras användning**

Bookingapi.php:

GET 		bookingapi.php	Hämtar alla bokningar

GET		bookingapi.php?=id	Hämtar bokning med givet id

POST		bookingapi.php	Lagrar ny bokning. Alla objekt behöver skickas med.

PUT		bookingapi.php	Uppdaterar befintlig bokning. Alla objekt behöver skickas med.

DELETE	bookingapi.php?=id	Raderar bokning med givet id

Menuapi.php:

GET		menuapi.php		Hämtar alla menyer.

GET		menuapi.php?=id	Hämtar meny med givet id.

POST		menuapi.php		Lagrar ny meny. Alla objekt behöver skickas med.

PUT		menuapi.php		Uppdaterar befintlig meny. Alla objekt behöver skickas med.

DELETE	menuapi.php?=id	Raderar meny med givet id. 
