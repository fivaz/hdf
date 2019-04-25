<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 1.10.2018
 * Time: 16:01
 */

include_once("model.php");

function fctPartnerAdd($lang_id, $name, $description, $image, $link, $position)
{
    try {
        $db = new myPDO();
        //$imageTemp = addslashes(file_get_contents($image)); //SQL Injection defence!
        //$sql = $db->prepare("INSERT INTO partner (IMAGE,LINK,POSITION) VALUES (:image, :link, :position)");
        $sql = $db->prepare("INSERT INTO PARTNER (IMAGE,LINK,POSITION) VALUES (:image,:link, :position) ");
        $sql->bindParam(':image', $image, PDO::PARAM_LOB);
        $sql->bindParam(':link', $link, PDO::PARAM_STR);
        $sql->bindParam(':position', $position, PDO::PARAM_INT);
        $sql->execute();

        $lastPartnerId = $db->lastInsertId();

        $sql = $db->prepare("INSERT INTO PART_LANG_TEXT (LANG_ID, PART_ID, NAME, DESCRIPTION) VALUES (:lang_id, :part_id, :name, :description)");
        $sql->bindParam(':lang_id', $lang_id, PDO::PARAM_INT);
        $sql->bindParam(':part_id', $lastPartnerId, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);
        $sql->execute();


    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            $error = -2;
        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $lastPartnerId;

}

/***fctPartnerTranslateAdd: Add a translation of a Partner and return rowCount()
 * @param $partnerId
 * @param $langId
 * @param $description
 * @param $title
 * @return int
 */
function fctPartnerTranslateAdd($partner_id, $lang_id, $name, $description)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO PART_LANG_TEXT (PART_ID, LANG_ID, NAME, DESCRIPTION) VALUES (:partner_id, :lang_id, :name, :description)");
        $sql->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $lang_id, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;

        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}

function fctPartnerEdit($partner_id, $lang_id, $name, $description, $link, $position,$isactive)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE PARTNER SET LINK= :link, POSITION = :position, ISACTIVE=:isactive WHERE PART_ID = :partner_id");
        $sql->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
        $sql->bindParam(':link', $link, PDO::PARAM_STR);
        $sql->bindParam(':position', $position, PDO::PARAM_INT);
        $sql->bindParam(':isactive', $isactive, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

        $sql = $db->prepare("UPDATE PART_LANG_TEXT SET NAME = :name, DESCRIPTION = :description WHERE PART_ID = :partner_id AND LANG_ID = :lang_id");
        $sql->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $lang_id, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);

        $sql->execute();

        $result += $sql->rowCount(); //2 si tout va bien

    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;

        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}

function fctPartnerEditImage($partner_id, $image)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE PARTNER SET IMAGE= :image WHERE PART_ID = :partner_id");
        $sql->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
        $sql->bindParam(':image', $image, PDO::PARAM_LOB);
        $sql->execute();

        $result = $sql->rowCount();


    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;

        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}


function fctPartnerList($lang = 1, $partner_id = 0)
{
    try {
        $db = new myPDO();

        if ($partner_id > 0) {
            $sql = $db->prepare("SELECT * FROM PARTNER p join PART_LANG_TEXT l on p.PART_ID = l.PART_ID where p.PART_ID=:partner_id AND l.LANG_ID= :lang order by p.POSITION,l.NAME");
            $sql->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
            $sql->bindParam(':lang', $lang, PDO::PARAM_INT);
        } else {
            $sql = $db->prepare("SELECT * FROM PARTNER p join PART_LANG_TEXT l on p.PART_ID = l.PART_ID WHERE l.LANG_ID=:lang order by p.POSITION,l.NAME");
            $sql->bindParam(':lang', $lang, PDO::PARAM_INT);
        }

        $sql->execute();
        $partnerList = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $partnerList;
}

function fctPartnerListClient($lang = 1, $partner_id = 0)
{
    try {
        $db = new myPDO();

        if ($partner_id > 0) {
            $sql = $db->prepare("SELECT * FROM PARTNER p join PART_LANG_TEXT l on p.PART_ID = l.PART_ID where p.PART_ID=:partner_id AND (p.ISACTIVE = 1 OR p.ISACTIVE IS NULL) AND l.LANG_ID= :lang order by p.POSITION,l.NAME");
            $sql->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
            $sql->bindParam(':lang', $lang, PDO::PARAM_INT);
        } else {
            $sql = $db->prepare("SELECT * FROM PARTNER p join PART_LANG_TEXT l on p.PART_ID = l.PART_ID WHERE l.LANG_ID=:lang AND (p.ISACTIVE = 1 OR p.ISACTIVE IS NULL) order by p.POSITION,l.NAME");
            $sql->bindParam(':lang', $lang, PDO::PARAM_INT);
        }

        $sql->execute();
        $partnerList = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $partnerList;
}

function fctPartnerDisable($partner_id)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("Update PARTNER SET ISACTIVE=0 where PART_ID=:partner_id");
        $sql->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->rowCount();


    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;

        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}

function fctPartnerEnable($partner_id)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("Update PARTNER SET ISACTIVE=1 where PART_ID=:partner_id");
        $sql->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->rowCount();


    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;

        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}


function clearPartnerDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM PART_LANG_TEXT");
        $sql->execute();

        $sql = $db->prepare("DELETE FROM PARTNER; ALTER TABLE PARTNER AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctDemoData
 */
function fctInsertPartnerDemoData()
{

    clearPartnerDatabase();

    fctPartnerAdd(1, "CAPRICES FESTIVAL CRANS-MONTANA", "Le Caprices Festival a été fondé en 2004 par cinq passionnés déterminés à faire rayonner leur région au travers de la musique et convaincus du potentiel d'un événement qui se démarquerait des autres, de part son emplacement et son originalité. Leur détermination s'est avérée payante car Caprices s'est rapidement imposé comme l'évènement musical incontournable du printemps.Après une première édition qui comptabilisait 10'000 visiteurs, la renommée du festival est allée grandissante au fil des ans. Caprices jouit désormais d'une réputation internationale notamment grâce à sa situation exceptionnelle au coeur des Alpes Valaisannes et à sa programmation éclectique qui fait la part belle aux artistes renommés, aux découvertes et aux talents suisses. De Lou Reed, en passant Iggy Pop, Scorpions, Samael, Robert Plant, Björk, Portishead, Nas, Fatboy Slim, Erykah Badu, Deep Purple, Mika, Nelly Furtado etc. le Caprices Festival a accueilli une pléiade de têtes d'affiches. ", file_get_contents("../resources/partner/caprices festival crans-montana.png"), "www.caprices.com", 5);

    fctPartnerAdd(1, "PALEO FESTIVAL NYON", "Depuis 1976, date de sa première édition qui, sous l’appellation First Folk Festival, réunissait 1800 personnes dans la salle communale de Nyon, le Paléo Festival est aujourd’hui un événement musical européen incontournable. Depuis sa création, le Festival a connu une croissance régulière et maîtrisée, amenant professionnalisation et développements. Chaque année, ce sont plus de 250 concerts et spectacles qui sont offerts aux quelque 230'000 spectateurs qui arpentent les 84 hectares du terrain de l’Asse (parkings compris), dans les hauteurs de Nyon. A ce jour, plus de 5 millions de personnes ont contribué à ce succès populaire qui ne faiblit pas. Depuis plus de douze ans, le Festival affiche complet avant même d’ouvrir ses portes et bénéficie d’une notoriété sans cesse grandissante. En 2013, plus de 600 représentants des médias ont couvert une édition marquée par des concerts d’inoubliables légendes et par ses installations artistiques comme autant d’invitations au rêve et à la contemplation.", file_get_contents("../resources/partner/paleo festival nyon.png"), "www.paleo.com", 3);


    fctPartnerAdd(1, "LEMANEO", "LémaNéo le site participatif et indépendant du Léman.Devenez acteur de la vie locale )Echangez, partagez, sortez, faites des rencontres selon vos activités ... sur LémaNéo, c'est vous qui participez !Grâce à LémaNéo, communiquez GRATUITEMENT tout autour du Léman et diffusez massivement grâce à son interconnexion avec tous les réseaux sociaux.Redécouvrez la démocratie participative positive et sur LémaNéo, nous ne sauvegardons pas vos données privées à vie ni ne les revendont à des sociétés tierces !", file_get_contents("../resources/partner/LEMANEO.png"), "www.lemaneo.com", 2);
    fctPartnerAdd(1, "VERBIER BIKE FEST", "Le Verbier Bike Fest, est un weekend festif qui s’adresse à tous les motards et non-motards même si la connotation Harley-Davidson est forte. De nombreuses attractions se déroule tout au long du week end. Avec plus de 10'000 visiteurs (estimation de 2014) ce grand rendez-vous de bikers est, dans son genre, le plus grand de Suisse !",file_get_contents("../resources/partner/verbier bike fest.png"),"www.verbierbikefest.com", 1);


}

function getPartner($partnerId = 0, $languageId = 1)
{
    $partner = fctPartnerList($languageId, $partnerId);
    if(!$partner){
        $partner = fctPartnerTranslateAdd($partnerId, $languageId, "", "");
    }
    return $partner;
}


//fctInsertPartnerDemoData();

?>
