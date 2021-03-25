<?php

$subjects = ['Plainte' => 'Plainte', 'Suggestion' => 'Suggestion', 'Information' => 'Information', 'Emploi' => 'Emploi'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($_POST as $key => $value) {
        $data[$key] = trim($value);

    }

    $errors = []; //array to file all the message errors

    if (empty($data['userFirstName'])) {
        $errors[] = 'Le prénom est obligatoire.';
    }

    if (empty($data['userLastName'])) {
        $errors[] = 'Le nom est obligatoire.';
    }

    if (empty($data['userEmail'])) {
        $errors[] = "L'email est obligatoire.";
    }


   
    $userFirstNameLength = 50;
    if (strlen($data['userFirstName']) > $userFirstNameLength) {
        $errors[] = "Le nom doit avoir moins de " . $userFirstNameLength . " caractères.";
    }
    $userLastNameLength = 100;
    if (strlen($data['userLastName']) > $userLastNameLength) {
        $errors[] = "Le nom doit avoir moins de " . $userLastNameLength . " caractères.";
    }
    
  
    if (!filter_var($data['userEmail'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Le format d'email n'est pas valable.";
    }
  
    if (!filter_var($data['userTelephone'], FILTER_SANITIZE_NUMBER_INT)) {
        $errors[] = "Le format de téléphone n'est pas valable.";
    }


    if (!in_array($data['reasonContact'], $subjects)) {
        $errors[] = "La raison de son contact n'est pas valable.";
    }

    if (empty($errors)) {
        header('Location: thanks.php');
    }

}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fic Page | Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <section class="contactMe">
        <h1>Contact us:</h1>

        <form action="" method="post">


            <?php if (!empty($errors)) { ?>
                <ul class="errorsList">

                    <?php foreach ($errors as $error) { ?>

                        <li><?= $error ?></li>

                    <?php } ?>

                </ul>

            <?php } ?>


            <label for="firstName">Prénom:</label>

            <input type="text" id="firstName" name="userFirstName" placeholder="John" value="<?= $data['userFirstName'] ?? '' ?>" required> <!-- Aqui no value, o sinal ?? vai fazer o seguinte: se existe um conteúdo em firstname você faz um echo, senao, vc mostra o valor seguinte, no caso nada, pq as aspas estão vazias.  -->
            <label for="lastName">Nom:</label>
            <input type="text" id="lastName" name="userLastName" placeholder="Smith" value="<?= $data['userLastName'] ?? '' ?>" required>

            <label for="telephone">Téléphone:</label>
            <input type="number" id="telephone" name="userTelephone" placeholder="01 02 03 04 05" value="<?= $data['userTelephone'] ?? '' ?>" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="userEmail" placeholder="johnsmith@john.com" value="<?= $data['userEmail'] ?? '' ?>" required>


            <label for="message">Votre message:</label>
            <textarea name="message" id="message" value="<?= $data['message'] ?? '' ?>" required>

    </textarea>

            <label for="reasonContact">Pourquoi nous contactez-vous?</label>
            <select name="reasonContact" id="reason" required>
                <option value="">-- Choisissez une option --</option>
                <?php
                
                // Loop to exhibit the options from select
                
                foreach ($subjects as $label => $subject) { ?>
                    <option value="<?= $subject ?>"><?= $label ?></option>



                <?php }; ?>



            </select>


            <input type="submit" value="Envoyer">

        </form>



    </section>
</body>

</html>
