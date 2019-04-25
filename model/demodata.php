<?php
/**
 * Insert Test and Demo data
 * User: Everyone
 * Date: 10.10.2018
 * Time: 09:19
 */

include_once("../global.php");

/*
 * Frank
 */
include_once("parameter_model.php");
include_once("calendar_model.php");
include_once("event_model.php");

/*
 * Daniel
 */
include_once("about_model.php");
include_once("partner_model.php");
include_once("user_model.php");

/*
 * Mithul
 */
include_once('ingredient_model.php');
include_once('location_model.php');
include_once('feedback_model.php');


// Clear all the tables
$article = new ArticleController();
$article->deleteAll();

$category = new CategoryController();
$category->deleteAll();

clearAboutDatabase();
clearPartnerDatabase();

//clearFoodIntoDatabase();
clearFeedbackDatabase();
clearUserDatabase();

//clearIngrUserDatabase();
clearIngredientDatabase();
//clearMenuDatabase();

clearCalendarDatabase();
clearEventDatabase();
clearLocationDatabase();

clearParameterDatabase();
clearLanguageDatabase();

/*
 * Frank
 */
fctInsertLanguages(); //Clear language table and insert FR + EN

$category->seed();

$article->seed();

fctInsertZeroIdUser(); //Insert Anonymous user with ID 0
fctInsertZeroIdEvent(); //Insert N/A event with ID 0
//fctInsertZeroIdLocation(); //Insert Location in GVA

fctParameterAdd(1, "COMPANY_NAME", "The Hot Dog Faktory");
fctParameterAdd(1, "COMPANY_LOGO", file_get_contents('../resources/logo.png'));
fctParameterAdd(1, "CONTACT_EMAIL", "info.thehotdogfaktory@16d.ch");
fctParameterAdd(1, "CONTACT_PHONE", "+ 41 76 818 62 98");
fctParameterAdd(1, "ADDRESS1", "Rue Rousseau 14");
fctParameterAdd(1, "ADDRESS2", "1201 Genève");
fctParameterAdd(1, "LINK_INSTAGRAM", "www.instagram.com");
fctParameterAdd(1, "LINK_FACEBOOK", "www.facebook.com");
fctParameterAdd(1, "LINK_TWITTER", "www.twitter.com");
fctParameterAdd(1, "LINK_TRIPADVISOR", "www.tripadvisor.com");

/*
* Daniel
*/
//User
$lastId=fctUserAdd("Administrateur", "Admin", "admin@gmail.com", "admin",1); //1
fctUserSetPrivilege($lastId,1);
$lastId=fctUserAdd("Testeur", "Test", "test@gmail.com", "test",1); //1
fctUserSetPrivilege($lastId,0);
$lastId=fctUserAdd("Cabrera", "Daniel", "dan.cabrera12@gmail.com", "daniel",1); //1
fctUserSetPrivilege($lastId,1);
$lastId=fctUserAdd("Théodoloz", "Frank", "fthe@bluewin.ch", "frank",1); //2
fctUserSetPrivilege($lastId,1);
$lastId=fctUserAdd("Fivaz", "Stefane", "stefane@gmail.com", "stefane",1); //3
fctUserSetPrivilege($lastId,1);
$lastId=fctUserAdd("Mahesalingam", "Mithul", "mithul@gmail.com", "mithul",1); //4
fctUserSetPrivilege($lastId,1);


/*
 * Mithul
 */
//Ingrédient
$LastId=fctIngredientAdd(1, "Pain classique");

$LastId=fctIngredientAdd(1, "Pain oignons");
fctIngredientTranslateAdd($LastId, 2,"Onion bread");
$LastId=fctIngredientAdd(1, "Pain curry");
$LastId=fctIngredientAdd(1, "Saucisse de porc");
fctIngredientTranslateAdd($LastId, 2,"Pork sausage");
$LastId=fctIngredientAdd(1, "Saucisse de veau");
$LastId=fctIngredientAdd(1, "Saucisse de volaille");
fctIngredientTranslateAdd($LastId, 2,"Poultry sausage");

$LastId=fctIngredientAdd(1, "Saucisse de boeuf");
$LastId=fctIngredientAdd(1, "Saucisse au tofu");
$LastId=fctIngredientAdd(1, "Chou");
$LastId=fctIngredientAdd(1, "Oignons");
$LastId=fctIngredientAdd(1, "Pousses d'oignons");
$LastId=fctIngredientAdd(1, "Guacamole");
$LastId=fctIngredientAdd(1, "Salade");
$LastId=fctIngredientAdd(1, "Ketchup");
$LastId=fctIngredientAdd(1, "Moutarde");
$LastId=fctIngredientAdd(1, "Sauce Bonbay");
$LastId=fctIngredientAdd(1, "Sauce tartare");

//Location
$lastId=fctLocationAdd(1, "Près de l'arrêt Lignon-Cité", "Lundi", "Avenue du lignon 54, 1219 le Lignon");
fctLocationTranslateAdd($lastId,2,"Monday","Next to the bus station");
fctLocationAdd(1, "Près de l'arrêt Lignon-Cité", "Lundi", "Avenue du lignon 54, 1219 le Lignon");
fctLocationAdd(1, "", "Mardi", "Avenue Cardinal-Mermillod 23, 1227 Carouge");
fctLocationAdd(1, "Proche du skatepark", "Mercredi", "Rue Dancet 22, 1205 Genève");

//Feedback
$lastId=fctFeedbackAdd(1, "Dupont Paul", "Bravo !", 5, "Très bon produits !", "dupont@gmail.com"); //1
fctFeedbackSetPublished($lastId,1);
$lastId=fctFeedbackAdd(0, "Kant Anthony", "Mauvais !", 1, "Prix chers et produits pas frais !", "kant@gmail.com");
fctFeedbackSetPublished($lastId,1);
$lastId=fctFeedbackAdd(0, "Curtet Jean", "Bon", 3, "savoureux, mais les prix sont un peu élevés.", "curtet@gmail.com");
fctFeedbackSetPublished($lastId,1);

/*
 * Daniel
 */
//About
$lastId=fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>PRODUIT</strong>", "<strong>Nos Hot Dogs</strong> allient des ingrédients d’exception du terroir suisse savamment élaborés et cuisinés par nos partenaires toqués de renommée internationale. Le Hot Dog devient un produit gourmet.", 1);
fctAboutTranslateAdd($lastId, 2,"THE<strong style='color:rgba(255,203,5,1)'> PRODUCT</strong>", "<strong>Our Hot Dog</strong> brings together exceptional Swiss regional ingredients skillfully prepared and cooked by our internationally-renowned partner chefs. The Hot Dog has become a gourmet product.");
fctAboutEnable($lastId);
$lastId=fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>ENGAGEMENT</strong>", "Travailler avec des produits frais et savoureux issus de l’agriculture suisse, proche de la nature et respectueuse des animaux. <strong>THE meilleur</strong> des fermes suisses se trouve dans nos Hot Dog ...", 2);
fctAboutTranslateAdd($lastId, 2,"THE <strong style='color:rgba(255,203,5,1)'>ENGAGEMENT</strong>", "To only use fresh, flavourful products produced by Swiss farmers who work in harmony with nature and are respectful of animals. We use only THE best products from Swiss farms in our Hot Dogs...");
fctAboutEnable($lastId);
$lastId=fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>POINT DE VENTE</strong>", "Nous disposons de 3 types de points de vente: <strong>In-Store</strong> (boutiques),<strong>mobile</strong>(Food truck et Karts) et<strong> événements majeurs</strong> (festivals, concerts, événements privés).
Nous souhaitons être flexibles et proposer nos produits de manière contrôlée et efficace.", 3);
fctAboutTranslateAdd($lastId, 2,"THE <strong style='color:rgba(255,203,5,1)'>POINT OF SALE</strong>", "We have three different points-of-sale: In-Store (stores), mobile (food trucks and carts) and major events (festivals, concerts, private events).
We want to be flexible and provide our products in a well-managed and efficient way.");
$lastId=fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>FRANCHISE</strong>", "Nous proposons aux personnes motivées et sensibles à nos engagements et valeurs de devenir <strong>franchisé THDF.</strong>
Partager et véhiculer l’amour du travail bien fait à travers un produit d’exception 100 % Swiss Made auprès du plus grand nombre de personnes.", 4);
fctAboutEnable($lastId);
$lastId=fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>DESSERT</strong>", "<strong>Notre gamme</strong> comporte également des Cookies, Brownies et autres spécialités américaines élaborées par nos chefs, toujours avec le même souci du détail.", 5);
fctAboutEnable($lastId);

//Partner
$lastId=fctPartnerAdd(1, "CAPRICES FESTIVAL CRANS-MONTANA", "Le Caprices Festival a été fondé en 2004 par cinq passionnés déterminés à faire rayonner leur région au travers de la musique et convaincus du potentiel d'un événement qui se démarquerait des autres, de part son emplacement et son originalité. Leur détermination s'est avérée payante car Caprices s'est rapidement imposé comme l'évènement musical incontournable du printemps.
Après une première édition qui comptabilisait 10'000 visiteurs, la renommée du festival est allée grandissante au fil des ans. Caprices jouit désormais d'une réputation internationale notamment grâce à sa situation exceptionnelle au coeur des Alpes Valaisannes et à sa programmation éclectique qui fait la part belle aux artistes renommés, aux découvertes et aux talents suisses. De Lou Reed, en passant Iggy Pop, Scorpions, Samael, Robert Plant, Björk, Portishead, Nas, Fatboy Slim, Erykah Badu, Deep Purple, Mika, Nelly Furtado etc. le Caprices Festival a accueilli une pléiade de têtes d'affiches.", file_get_contents('../resources/partner/CAPRICES FESTIVAL CRANS-MONTANA.png'), "www.caprices.com", 5);
fctPartnerEnable($lastId);

$lastId=fctPartnerAdd(1, "PALEO FESTIVAL NYON", "Depuis 1976, date de sa première édition qui, sous l’appellation \"First Folk Festival\", réunissait 1800 personnes dans la salle communale de Nyon, le Paléo Festival est aujourd’hui un événement musical européen incontournable. Depuis sa création, le Festival a connu une croissance régulière et maîtrisée, amenant professionnalisation et développements. Chaque année, ce sont plus de 250 concerts et spectacles qui sont offerts aux quelque 230'000 spectateurs qui arpentent les 84 hectares du terrain de l’Asse (parkings compris), dans les hauteurs de Nyon. A ce jour, plus de 5 millions de personnes ont contribué à ce succès populaire qui ne faiblit pas. Depuis plus de douze ans, le Festival affiche complet avant même d’ouvrir ses portes et bénéficie d’une notoriété sans cesse grandissante. En 2013, plus de 600 représentants des médias ont couvert une édition marquée par des concerts d’inoubliables légendes et par ses installations artistiques comme autant d’invitations au rêve et à la contemplation.", file_get_contents('../resources/partner/PALEO FESTIVAL NYON.png'), "www.paleo.com", 1);
fctPartnerTranslateAdd($lastId, 2,"PALEO FESTIVAL NYON
", "The Paléo Festival brought together 1800 people in the Nyon municipal hall for its first edition, the \"First Folk Festival\", in 1976. It has since become a leading European musical event. The Festival's growth has been consistent and well managed since its beginnings. It has become more professional and added events. It now offers over 250 concerts and shows every year to the 230,000 people who come to stroll about the 84 hectares at Asse (parking lots included) above Nyon. To date, over five million people have contributed to the popular success of the festival which shows no sign of weakening. For the past 12 years, the Festival has been sold out even before its doors open and its renown continues to grow. In 2013, over 600 media representatives covered the festival which featured concerts by unforgettable legends and art installations which were an invitation to dreaming and contemplation.");
fctPartnerEnable($lastId);

$lastId=fctPartnerAdd(1, "LEMANEO", "LémaNéo le site participatif et indépendant du Léman.
Devenez acteur de la vie locale ;)
Echangez, partagez, sortez, faites des rencontres selon vos activités ... sur LémaNéo, c'est vous qui participez !
Grâce à LémaNéo, communiquez GRATUITEMENT tout autour du Léman et diffusez massivement grâce à son interconnexion avec tous les réseaux sociaux.
Redécouvrez la démocratie participative positive et sur LémaNéo, nous ne sauvegardons pas vos données privées à vie ni ne les revendont à des sociétés tierces !", file_get_contents('../resources/partner/LEMANEO.png'), "www.lemaneo.com", 2);

fctPartnerTranslateAdd($lastId, 2,"LEMANEO", "LémaNéo is the Léman's independent participative website. Take part in local life ;) Exchange, share, go out, meet people with similar interests...you're involved on LémaNéo!
Thanks to LémaNéo you can communicate FREE around the Léman and broadcast massively thanks to its links to all social networks.
Rediscover positive participatory democracy. Your private data is not stored on LémaNéo forever and they will never be sold to third party companies.");
fctPartnerEnable($lastId);

$lastId=fctPartnerAdd(1, "VERBIER BIKE FEST", "Le Verbier Bike Fest, est un weekend festif qui s’adresse à tous les motards et non-motards même si la connotation Harley-Davidson est forte. De nombreuses attractions se déroule tout au long du week end. Avec plus de 10'000 visiteurs (estimation de 2014) ce grand rendez-vous de bikers est, dans son genre, le plus grand de Suisse !", file_get_contents('../resources/partner/VERBIER BIKE FEST.png'), "www.verbierbikefest.com", NULL);
fctPartnerTranslateAdd($lastId, 2,"VERBIER BIKE FEST", "The Verbier Bike Fest is a festive weekend for all bikers and non-bikers although Harley-Davidson connotation is strong. Many attractions are taking place throughout the weekend. With more than 10,000 visitors (2014 estimation) this great appointment bikers is, in its way, the largest in Switzerland!");
fctPartnerEnable($lastId);

//Events
$lastId = fctEventAdd(1, "Fête de la saucisse", "Retrouvez-nous à la première fête de la saucisse !!!", "Place de Frankfort, 1208 Genève", "", file_get_contents('../resources/event/FeteSaucisse.png'));
fctEventTranslateAdd($lastId, 2, "Sausage party", "Meet us at the the first sausage party !!!");
fctCalendarAdd(0, $lastId, "EVENT", "2018-11-09 11:30", "2018-11-11 18:00");
$lastId = fctEventAdd(1, "Inauguration du nouveau Food Truck", "Nous inaugurons notre tout nouveau Food Truck, profitez d'un rabais de 20% sur tous nos hot-dogs", "Plaine de Plainpalais, 1208 Genève", "http://google.com", file_get_contents('../resources/event/foodtruck.jpg'));
fctEventTranslateAdd($lastId, 2, "Inauguration of our new Food Truck", "We are inaugurating our brand new Food Truck, enjoy a 20% discount on all our hot dogs");
fctCalendarAdd(0, $lastId, "EVENT", "2018-11-03 11:30", "2018-11-03 19:30");
