<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 1.10.2018
 * Time: 16:01
 */

include_once("model.php");


function fctAboutAdd($lang_id, $title, $description, $position)
{
    try {
        $db = new myPDO();
        $sql = $db->prepare("INSERT INTO ABOUT (POSITION) VALUES (:position)");
        $sql->bindParam(':position', $position, PDO::PARAM_INT);
        $sql->execute();

        $lastAboutId = $db->lastInsertId();

        $sql = $db->prepare("INSERT INTO ABOU_LANG_TEXT (LANG_ID, ABOU_ID, TITLE, DESCRIPTION) VALUES (:lang_id, :about_id, :title, :description)");
        $sql->bindParam(':lang_id', $lang_id, PDO::PARAM_INT);
        $sql->bindParam(':about_id', $lastAboutId, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
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
    return $lastAboutId;
}

function fctAboutTranslateAdd($about_id, $lang_id, $title, $description)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO ABOU_LANG_TEXT (ABOU_ID, LANG_ID, TITLE, DESCRIPTION) VALUES (:about_id, :lang_id, :title, :description)");
        $sql->bindParam(':about_id', $about_id, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $lang_id, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
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

function fctAboutEdit($lang_id, $about_id, $title, $description, $position, $isactive)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE ABOUT SET POSITION = :position, ISACTIVE=:isactive WHERE ABOU_ID = :about_id");
        $sql->bindParam(':about_id', $about_id, PDO::PARAM_INT);
        $sql->bindParam(':position', $position, PDO::PARAM_INT);
        $sql->bindParam(':isactive', $isactive, PDO::PARAM_INT);

        $sql->execute();

        $result = $sql->rowCount();

        $sql = $db->prepare("UPDATE ABOU_LANG_TEXT SET TITLE = :title, DESCRIPTION = :description WHERE ABOU_ID = :about_id AND LANG_ID = :lang_id");
        $sql->bindParam(':about_id', $about_id, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $lang_id, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);

        $sql->execute();

        $result += $sql->rowCount();

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

function fctAboutList($lang = 1, $about_id = 0)
{
    try {
        $db = new myPDO();

        if ($about_id > 0) {
            $sql = $db->prepare("SELECT * FROM ABOUT a join ABOU_LANG_TEXT l on a.ABOU_ID = l.ABOU_ID WHERE a.ABOU_ID=:about_id AND l.LANG_ID=:lang order by a.POSITION,l.TITLE");
            $sql->bindParam(':about_id', $about_id, PDO::PARAM_INT);
            $sql->bindParam(':lang', $lang, PDO::PARAM_INT);

        } else {
            $sql = $db->prepare("SELECT * FROM ABOUT a join ABOU_LANG_TEXT l on a.ABOU_ID = l.ABOU_ID WHERE l.LANG_ID=:lang order by  a.POSITION,l.TITLE");
            $sql->bindParam(':lang', $lang, PDO::PARAM_INT);

        }

        $sql->execute();
        $aboutList = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $aboutList;
}


function fctAboutDisable($about_id)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("Update ABOUT SET ISACTIVE=0 where ABOU_ID=:about_id");
        $sql->bindParam(':about_id', $about_id, PDO::PARAM_INT);
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

function fctAboutEnable($about_id)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("Update ABOUT SET ISACTIVE=1 where ABOU_ID=:about_id");
        $sql->bindParam(':about_id', $about_id, PDO::PARAM_INT);
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

function clearAboutDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM ABOU_LANG_TEXT");
        $sql->execute();

        $sql = $db->prepare("DELETE FROM ABOUT; ALTER TABLE ABOUT AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}


/***
 * fctInsertAboutDemoData
 */
function fctInsertAboutDemoData()
{

    clearAboutDatabase();

    fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>PRODUIT</strong>", "<strong>Nos Hot Dogs</strong> allient des ingrédients d’exception du terroir suisse savamment élaborés et cuisinés par nos partenaires toqués de renommée internationale. Le Hot Dog devient un produit gourmet.", 1);
    fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>ENGAGEMENT</strong>", "Travailler avec des produits frais et savoureux issus de l’agriculture suisse, proche de la nature et respectueuse des animaux. <strong>THE meilleur</strong> des fermes suisses se trouve dans nos Hot Dog ...", 2);
    fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>POINT DE VENTE</strong>", "Nous disposons de 3 types de points de vente: <strong>In-Store</strong> (boutiques),<strong>mobile</strong>(Food truck et Karts) et<strong> événements majeurs</strong> (festivals, concerts, événements privés).
Nous souhaitons être flexibles et proposer nos produits de manière contrôlée et efficace.", 3);
    fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>FRANCHISE</strong>", "Nous proposons aux personnes motivées et sensibles à nos engagements et valeurs de devenir <strong>franchisé THDF.</strong>
Partager et véhiculer l’amour du travail bien fait à travers un produit d’exception 100 % Swiss Made auprès du plus grand nombre de personnes.", 4);
    fctAboutAdd(1, "THE <strong style='color:rgba(255,203,5,1)'>DESSERT</strong>", "<strong>Notre gamme</strong> comporte également des Cookies, Brownies et autres spécialités américaines élaborées par nos chefs, toujours avec le même souci du détail.", 5);

//    For English

    fctAboutAdd(2, "THE<strong style='color:rgba(255,203,5,1)'> PRODUCT</strong>", "<strong>Our Hot Dog</strong> brings together exceptional Swiss regional ingredients skillfully prepared and cooked by our internationally-renowned partner chefs. The Hot Dog has become a gourmet product.", 1);
    fctAboutAdd(2, "THE <strong style='color:rgba(255,203,5,1)'>ENGAGEMENT</strong>", "To only use fresh, flavourful products produced by Swiss farmers who work in harmony with nature and are respectful of animals. We use only THE best products from Swiss farms in our Hot Dogs...", 2);
    fctAboutAdd(2, "THE <strong style='color:rgba(255,203,5,1)'>POINT OF SALE</strong>", "We have three different points-of-sale: In-Store (stores), mobile (food trucks and carts) and major events (festivals, concerts, private events).
We want to be flexible and provide our products in a well-managed and efficient way.",3);
}

//STEFANE
function getAbout($aboutId = 0, $languageId = 1)
{
    $about = fctAboutList($languageId, $aboutId);
    if(!$about){
        $about = fctAboutTranslateAdd($aboutId, $languageId, "", "");
    }
    return $about;
}


//fctInsertAboutDemoData();
//fctAboutEdit(1,1,"THE BOB","The paeoe",1);

?>
