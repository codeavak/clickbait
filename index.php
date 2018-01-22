<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php
      define("TITLE","Clickbait Headline Neutralizer");
    
    //PHP CONSOLE LOG FUNCTION
     function logConsole($name, $data = NULL, $jsEval = FALSE)
 {
      if (! $name) return false;

      $isevaled = false;
      $type = ($data || gettype($data)) ? 'Type: ' . gettype($data) : '';

      if ($jsEval && (is_array($data) || is_object($data)))
      {
           $data = 'eval(' . preg_replace('#[\s\r\n\t\0\x0B]+#', '', json_encode($data)) . ')';
           $isevaled = true;
      }
      else
      {
           $data = json_encode($data);
      }

      # sanitalize
      $data = $data ? $data : '';
      $search_array = array("#'#", '#""#', "#''#", "#\n#", "#\r\n#");
      $replace_array = array('"', '', '', '\\n', '\\n');
      $data = preg_replace($search_array,  $replace_array, $data);
      $data = ltrim(rtrim($data, '"'), '"');
      $data = $isevaled ? $data : ($data[0] === "'") ? $data : "'" . $data . "'";

$js = <<<JSCODE
\n<script>
 // fallback - to deal with IE (or browsers that don't have console)
 if (! window.console) console = {};
 console.log = console.log || function(name, data){};
 // end of fallback

 console.log('$name');
 console.log('------------------------------------------');
 console.log('$type');
 console.log($data);
 console.log('\\n');
</script>
JSCODE;

      echo $js;
 } //end php console log function
?>

        <title>
            <?php echo TITLE ?> </title>

        <!-- Bootstrap core CSS -->
        <link href="bs/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style>
            body {
                padding-top: 54px;
            }

            @media (min-width: 992px) {
                body {
                    padding-top: 56px;
                }
            }

            .before-phrase {
                background-color: indianred;
                color: black;
            }

            .after-phrase {
                background-color: darkseagreen;
                color: black;

            }

            .how-to-use {
                background-color: pink;
                color: black;
            }

        </style>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <?php echo TITLE ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <h1 class="text-center">
        <?php echo TITLE ?>
    </h1>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <form class="col-sm-10 col-sm-offset-2" action="" method="post">
                <div class="form-group">
                    <textarea class="form-control input-lg" id="exampleInputEmail1" placeholder="Enter Clickbait Phrase" name="clickbait_headline"></textarea>
                    <button type="submit" class="btn btn-primary btn-lg pull-right" name="fix_submit">Submit</button>
                </div>


            </form>
        </div>

        <div class="row">
            <div class="col-sm-6 before-phrase">
                <?php if(isset ($_POST["fix_submit"])) {
                        echo "<h1>Clickbait headline:</h1><br><br>";
                        echo $_POST["clickbait_headline"];} 
                ?>
            </div>
            <div class="col-sm-6 after-phrase">
                <?php if(isset ($_POST["fix_submit"])) {
                        echo "<h1>Honest headline:</h1><br><br>";
                        convert_to_honest();} 
                ?>
            </div>

        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-12 how-to-use">
                <h3>How to use?</h3>
                <p>Enter a clickbait headline in the text area and click submit. The headline must contain at least one of the following words that are commonly used in clickbait headlines: </p>
                <ul>
                    <li>scientists</li>
                    <li>doctors</li>
                    <li>hate</li>
                    <li>stupid</li>
                    <li>weird</li>
                    <li>simple</li>
                    <li>trick</li>
                    <li>shocked me</li>
                    <li>you'll never believe</li>
                    <li>hack</li>
                    <li>epic</li>
                    <li>unbelievable</li>
                </ul>
            </div>
        </div>

     <?php
        function convert_to_honest()
            {
            logConsole("Is the form submitted?", "Yes", true);
            $honestHeadline = strtolower($_POST["clickbait_headline"]);
            $a = array(
                "scientists",
                "doctors",
                "hate",
                "stupid",
                "weird",
                "simple",
                "trick",
                "shocked me",
                "you'll never believe",
                "hack",
                "epic",
                "unbelievable"
            );
            $b = array(
                "so-called scientists",
                "self-proclaimed doctors",
                "are not threatened by",
                "average",
                "completely normal",
                "ineffective",
                "method",
                "did not shock me at all",
                "you'll not be surprised",
                "slightly improve",
                "boring",
                "normal"
            );
            $honestHeadline = str_replace($a, $b, $honestHeadline);
            $honestHeadline = ucfirst($honestHeadline);
            echo $honestHeadline;
            } 
        ?>
            <!-- Bootstrap core JavaScript -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
