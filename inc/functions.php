<!--NavBar generation-->
<?php
$navbar = ['Log In'=>'login',
			 'Home'=>'home',
			 'Flight Details'=>'details',
			 'Order Flight' =>'order'];

function renderNav($navArray) {
	foreach ($navArray as $name=>$link):?> 
		<li><a href='?page=<?=$link?>'><?=$name?></a></li>
		<?php endforeach ?>

<?php
};
?>


<!--Mailer function-->
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if(isset($_POST['send']) || isset($_POST['feedback'])){
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function


//Load Composer's autoloader


$mail = new PHPMailer(true);                  // Passing `true` enables exceptions
    try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'kalafioras.serveriai.lt';               // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'send@ldauto.lt';                 // SMTP username
    $mail->Password = 'Testas123';       // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to


    //Recipients
    $mail->setFrom('send@ldauto.lt', 'Mailer');
    $mail->addAddress (htmlspecialchars($_POST['email']), htmlspecialchars($_POST['name']));     // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
        if(isset($_POST['send'])){
            $mail->Subject = 'We got Problem';
        }else{
            $mail->Subject = 'We got Feedback';
        }

    $mail->Body    = htmlspecialchars($_POST['message']);

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

    $mail->send();
        header("Location:index.php");
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}


?>


<?php
//MYSQL Best offer

try {
    $conn = new PDO($dsn, $username, $password);
    $bestOffer =  $conn->query("SELECT flight.name, flight.description, flight.id FROM flight JOIN category ON flight.flight_cat = category.id WHERE flight.flight_cat = 1 LIMIT 3");
    $offer = $bestOffer->fetchAll(PDO::FETCH_ASSOC);
    $categories =  $conn->query("SELECT flight.name AS flights, flight.description, category.name FROM flight INNER JOIN category ON category.id = flight.flight_cat ORDER BY category.name desc");
    $categoryName = $categories->fetchAll(PDO::FETCH_ASSOC);

    $id = "0";
    if(isset($_GET['id'])) {
        $val = $_GET['id'];
        //echo $val;

        $moreInfo = "SELECT * FROM flight JOIN category ON flight.flight_cat = category.id WHERE flight.id = :id";
        $id = $_GET['id'];

        $statement = $conn->prepare($moreInfo);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        $info = $statement->fetchAll();
        //var_dump($info);
    }
} catch(Exception $e){
    echo $e;
}
function generateDeal($data){
    foreach ($data as $key):?>
        <div class="4u 12u$(medium)">
            <section class="box">
                <i class="icon big rounded color1 fa-cloud"></i>
                <h3><?=$key['name']?></h3>
                <p> <?=$key['description']?></p>
                <a href="?page=details&id=<?=$key['id']?>" type="submit" class="button md moreInfo"  name="getVal">Plačiau</a>
            </section>
        </div>
    <?php endforeach;
}
//MYSQL categories select
function categoryList($data){
    foreach ($data as $key):?>

        <div class="4u 12u$(medium)">

            <section class="box">
                <h3><?=$key['name']?></h3>
                <i class="icon big rounded color1 fa-cloud"></i>
                <h4><?=$key['flights']?></h4>
                <p> <?=$key['description']?></p>
                <button type="submit" class="button md ">Plačiau</button>
            </section>
        </div>
    <?php endforeach;
}
//MYSQL more Info
//if(isset($_GET['id'])) {
//    $val = $_GET['id'];
//
//    echo $val;
//}
function moreInfo($info){

    foreach ($info as $key):?>
        <div class="12u 12u$(medium)">

            <section class="box">
                <h3><?= $key['name'] ?></h3>
                <i class="icon big rounded color1 fa-cloud"></i>
                <p> <?= $key['description'] ?></p>
                <p> <?= $key['price'] ?></p>
                <p> <?= $key['flight_from'] ?></p>
                <p> <?= $key['flight_to'] ?></p>
            </section>
        </div>

    <?php endforeach;

}


//MYSQL TABLE IN avip/tables.php

function createRows($connection){
    $rows =  $connection->query("SELECT flight.id, flight.name, flight.description, flight.flight_from, flight.flight_to, flight.price, category.name AS category FROM flight INNER JOIN category ON category.id = flight.flight_cat ORDER BY flight.id");
    $tableRows = $rows->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tableRows as $key):?>
            <tr>
                <td><?= $key['id'] ?></td>
                <td><?= $key['name'] ?></td>
                <td><?= $key['description'] ?></td>
                <td><?= $key['flight_from'] ?></td>
                <td><?= $key['flight_to'] ?></td>
                <td><?= $key['price'] ?></td>
                <td><?= $key['category'] ?></td>
                <td style="text-align: center"><a href="?page=tables&delete&id=<?=$key['id']?>"><i class="far fa-trash-alt" style="color: #e82643"></i></a></td>
                <td style="text-align: center"><a href="?page=tables&edit&id=<?=$key['id']?>"><i class="far fa-edit" style="color: #256be8"></i></a></td>
            </tr>
    <?php endforeach;
}

//ADMIN

    if(isset($_POST['submitForm'])){
        updateTable($conn, "submitForm");
    }else if(isset($_POST['updateForm'])){
        updateTable($conn, "updateForm");
    }
//MYSQL function for read table

function updateTable($connection, $type){
    //$rows =  $connection->query("SELECT * FROM flight INNER JOIN category ON category.id = flight.flight_cat ORDER BY category.name desc");



    $flightName = $_POST['name'];
    $flightDescription = $_POST['description'];
    $flightFrom = $_POST['from'];
    $flightTo = $_POST['to'];
    $flightPrice = $_POST['price'];
    $flightCategory = $_POST['category'];

if($type == "submitForm") {

    $sql = "INSERT INTO flight (name, description, flight_from, flight_to, price, flight_cat) VALUE (:name, :description, :from, :to, :price, :category)";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':name', $flightName, PDO::PARAM_STR);
    $statement->bindParam(':description', $flightDescription, PDO::PARAM_STR);
    $statement->bindParam(':from', $flightFrom, PDO::PARAM_STR);
    $statement->bindParam(':to', $flightTo, PDO::PARAM_STR);
    $statement->bindParam(':price', $flightPrice, PDO::PARAM_STR);
    $statement->bindParam(':category', $flightCategory, PDO::PARAM_STR);
    $statement->execute();

}else if($type == "updateForm") {
    $flightID = $_GET['id'];
    $stmt = $connection->prepare("SELECT * FROM flight WHERE flight.id = :id");
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
        $sql = "UPDATE flight SET name = :name, description = :description, flight_from = :from, flight_to = :to, price = :price, flight_cat = :category WHERE flight.id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $flightID, PDO::PARAM_STR);
        $statement->bindParam(':name', $flightName, PDO::PARAM_STR);
        $statement->bindParam(':description', $flightDescription, PDO::PARAM_STR);
        $statement->bindParam(':from', $flightFrom, PDO::PARAM_STR);
        $statement->bindParam(':to', $flightTo, PDO::PARAM_STR);
        $statement->bindParam(':price', $flightPrice, PDO::PARAM_STR);
        $statement->bindParam(':category', $flightCategory, PDO::PARAM_STR);
        $statement->execute();

    }
}
}
//MYSQL Delete ROW in tables.php

if(isset($_GET['id']) && isset($_GET['delete'])){
    DeleteRow($conn);
}
function DeleteRow($connection){
    $rowId = $_GET['id'];
    $sql = "DELETE FROM flight WHERE flight.id = $rowId";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':name', $flightName, PDO::PARAM_STR);
    $statement->bindParam(':description', $flightDescription, PDO::PARAM_STR);
    $statement->bindParam(':from', $flightFrom, PDO::PARAM_STR);
    $statement->bindParam(':to', $flightTo, PDO::PARAM_STR);
    $statement->bindParam(':price', $flightPrice, PDO::PARAM_STR);
    $statement->bindParam(':category', $flightCategory, PDO::PARAM_STR);
    $statement->execute();
}

//MYSQL EDIT ROW in tables.php

function editRow($connection){
    $rowId = $_GET['id'];

    $sql = "SELECT * FROM flight WHERE flight.id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $rowId, PDO::PARAM_STR);
    $statement->execute();
    $value = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>
<div class="span9" id="content">
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Editing Form <?=$value[0]['id']?></div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=$value[0]['name']?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?=$value[0]['description']?>">
                    </div>
                    <div class="form-group">
                        <label for="from">Flight From</label>
                        <input type="text" class="form-control" id="from" name="from" value="<?=$value[0]['flight_from']?>">
                    </div>
                    <div class="form-group">
                        <label for="to">Flight To</label>
                        <input type="text" class="form-control" id="to" name="to" value="<?=$value[0]['flight_to']?>">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?=$value[0]['price']?>">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="1">Sale</option>
                            <option value="2">Festival</option>
                            <option value="3">Family Vacation</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-default" name="updateForm">Edit</button>
                   <a href="?page=tables" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>

    </div>
</div>

<?php
}

//login
if (!isset($_POST['login'])) {

}else{
    if($_POST['username'] == "admin" && $_POST['password'] == 'admin'){
        $_SESSION['username'] = 'admin';
        //var_dump($_POST['username']);
        include "avip/tables.php";
    }else{
        echo "neteisingi duomenys";
    }
}

//if(isset($_POST['login'])){
//    $login = $_POST['username'];
//    $password = $_POST['password'];
//    echo $login . "<br>" . $password;
//}