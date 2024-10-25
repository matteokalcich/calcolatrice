<?php
session_start();



if (!isset($_SESSION['textArea'])) {
    $_SESSION['textArea'] = '';
}

if(!isset($_SESSION['mode'])){

    $_SESSION['mode'] = 'DEC';
}

if(isset($_POST['mode'])){

    if($_POST['mode'] == 'HEX'){

        $_SESSION['mode'] = 'DEC';

    } else{

        $_SESSION['mode'] = 'HEX';
    }
}

if (isset($_POST['numero'])) {

    $_SESSION['textArea'] .= $_POST['numero'];
}

if (isset($_POST['operatore'])) {
    $_SESSION['primoNumero'] = $_SESSION['textArea'];
    $_SESSION['operatore'] = $_POST['operatore'];
    $_SESSION['textArea'] = '';
}

if(isset($_POST['hex'])){

    $_SESSION['textArea'] .= $_POST['hex'];
}

if (isset($_POST['uguale'])) {
    $secondoNumero = $_SESSION['textArea'];

    if($_SESSION['mode'] == 'HEX'){ 

        //echo 'DEC'; //current mode


        if ($_SESSION['operatore'] == '+') {

            $_SESSION['textArea'] = $_SESSION['primoNumero'] + $secondoNumero;

        } elseif ($_SESSION['operatore'] == '-') {

            $_SESSION['textArea'] = $_SESSION['primoNumero'] - $secondoNumero;

        } elseif ($_SESSION['operatore'] == '/') {

            if ($secondoNumero == 0) {

                $_SESSION['textArea'] = 'Impossibile dividere per 0';

            } else {

                $_SESSION['textArea'] = $_SESSION['primoNumero'] / $secondoNumero;

            }

        } elseif ($_SESSION['operatore'] == '*') {

            $_SESSION['textArea'] = $_SESSION['primoNumero'] * $secondoNumero;
        }

    } else{

        //echo 'HEX'; //mode

        $hexPrimo = hexdec($_SESSION['primoNumero']);

        $hexSecondo = hexdec($secondoNumero);

        if ($_SESSION['operatore'] == '+') {

            $risultato = $hexPrimo + $hexSecondo;

            $_SESSION['textArea'] = dechex($risultato);

        }
    }

    
    
}

if (isset($_POST['cancella'])) {
    $_SESSION['textArea'] = '';
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- importo bootstrap -->
    <title>Calcolatrice</title>
</head>

<body class="d-flex align-items-center" style="height: 100vh;">

    <div class="container w-25">
        <div class="d-flex justify-content-center">
            <div class="w-100">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-6 w-100 text-center">
                            <p>Current mode: <?php 
                            
                            if($_SESSION['mode'] == 'HEX'){

                                echo 'DEC';
                            } else{

                                echo 'HEX';
                            }
                             
                            
                            ?></p>
                        </div>
                        <div class="col-6 w-100">

                            <input type="text" value="<?php echo $_SESSION['textArea']; ?>" class="form-control" disabled>

                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-4">
                                    <button type="submit" class="btn w-100 border" name="numero" value="1">1</button>
                                    <button type="submit" class="btn w-100 border" name="numero" value="4">4</button>
                                    <button type="submit" class="btn w-100 border" name="numero" value="6">6</button>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn w-100 border" name="numero" value="2">2</button>
                                    <button type="submit" class="btn w-100 border" name="numero" value="5">5</button>
                                    <button type="submit" class="btn w-100 border" name="numero" value="7">7</button>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn w-100 border" name="numero" value="3">3</button>
                                    <button type="submit" class="btn w-100 border" name="numero" value="8">8</button>
                                    <button type="submit" class="btn w-100 border" name="numero" value="9">9</button>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <button type="submit" class="btn w-100 border" name="numero" value="0">0</button>
                                </div>

                            </div>

                            <?php

                            if ($_SESSION['mode'] == 'DEC') {

                                //HEX mode

                                echo '
                                <div class="row mt-2">

                                    <div class="col-4">

                                        <button type="submit" class="btn w-100 border" name="hex" value="A">A</button>

                                    </div>
                                    <div class="col-4">

                                        <button type="submit" class="btn w-100 border" name="hex" value="B">B</button>
                                    </div>
                                    <div class="col-4">

                                        <button type="submit" class="btn w-100 border" name="hex" value="C">C</button>

                                    </div>
                                </div>

                                <div class="row mt-2">

                                    <div class="col-4">

                                        <button type="submit" class="btn w-100 border" name="hex" value="D">D</button>

                                    </div>
                                    <div class="col-4">

                                        <button type="submit" class="btn w-100 border" name="hex" value="E">E</button>
                                    </div>
                                    <div class="col-4">

                                        <button type="submit" class="btn w-100 border" name="hex" value="F">F</button>

                                    </div>
                                </div>
                                ';

                            }
                            
                            ?>

                            <div class="row mt-2">

                                <div class="col-6">
                                    <button type="submit" class="btn btn-danger w-100" name="cancella" value="AC">AC</button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-success w-100" name="uguale" value="=">=</button>
                                </div>
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn w-100 border" name="operatore" value="+">+</button>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn w-100 border" name="operatore" value="-" <?php if($_SESSION['mode'] == 'DEC') {echo 'disabled';}?>>-</button>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn w-100 border" name="operatore" value="/" <?php if($_SESSION['mode'] == 'DEC') {echo 'disabled';}?>>/</button>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn w-100 border" name="operatore" value="*" <?php if($_SESSION['mode'] == 'DEC') {echo 'disabled';}?>>x</button>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn w-100 border" name="mode" value="<?php echo $_SESSION['mode']; ?>"><?php echo $_SESSION['mode']; ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>