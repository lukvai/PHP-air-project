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
    $bestOffer =  $conn->query("SELECT flight.name, flight.description, flight.id FROM flight JOIN category ON flight.flight_cat = category.id WHERE flight.flight_cat = 1");
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



