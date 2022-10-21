<?php
    // echo "<h1>Hello world </h1>";

    // $num = 1000000;
    // $data = strlen($num);
    // echo $data;
    // if($data == 1){
    //     echo "ខ្ទង់រាយ";
    // }elseif($data == 2){
    //     echo "ខ្ទង់ដប់";
    // }elseif($data == 3){
    //     echo "ខ្ទង់រយ";
    // }elseif($data == 4){
    //     echo "ខ្ទង់ពាន់";
    // }elseif($data == 5){
    //     echo "ខ្ទង់ម៉ឺន";
    // }elseif($data == 6){
    //     echo "ខ្ទង់សែ​ន";
    // }
    // elseif($data == 7){
    //     echo "ខ្ទង់លាន";
    // }else{
    //     echo "Only 6 degit numbers!";
    // }   

    // echo 'Read In Thousand:' .num2khtext('11989',true);
    // echo 'Not Read In Thousand:' .num2khtext('11989',false);
    // function num2khtext($complete_char,$enableThousand){
    //     //function for split uft8 character
    //     function mb_str_split( $string ) { 
    //     //Split at all position not after the start: ^ 
    //     //and not before the end: $ 
    //     return preg_split('/(?<!^)(?!$)/u', $string ); 
    //     }		
    //     //remove left zeros
    //     $cleanStr = ltrim($complete_char, '0');	
    //     //split number/string to array
    //     $num_arr = mb_str_split($cleanStr);	
    //     $translated=''; $addThousand=false;
    //     //string array
    //     $khNUMTxt = array('','មួយ','ពីរ','បី','បួន','ប្រាំ');
    //     $twoLetter = array('','ដប់','ម្ភៃ','សាមសិប','សែសិប','ហាសិប','ហុកសិប','ចិតសិប','ប៉ែតសិប','កៅសិប');
    //     $khNUMLev = array('','','','រយ','ពាន់','មឿន','សែន','លាន');
    //     $khnum = array('០','១','២','៣','៤','៥','៦','៧','៨','៩');
    //     //loop to check each number character
    //     foreach($num_arr as $key=>$value){
    //     //convert khmer number to latin number if found
    //     if(in_array($value,$khnum)){$value = array_search($value,$khnum);}
    //     //allow only number
    //     if(!is_numeric($value)){return '';}
    //     //check what pos the charactor in
    //     $pos = count($num_arr) - ($key);
    //     if($pos>count($khNUMLev)-1){$pos=($pos % count($khNUMLev))+2;}
    //     //enable or diable read in thousand
    //     if($enableThousand and ($pos == 5 or $pos == 6)){$pos = $pos-3;}
    //     //concatenate number as text
    //     if($pos==2){
    //     $translated .= $twoLetter[$value];
    //     }else{
    //     if($value>5){$translated .=  $khNUMTxt[5].$khNUMTxt[$value - 5];}else{$translated .= $khNUMTxt[$value];}
    //     }
    //     //work for thousand
    //     if($pos==2 or $pos == 3 or $pos == 4){
    //     if($value>0){$addThousand=true;}
    //     }
    //     //concatenate number level
    //     if($value>0 or ($pos==4 and $addThousand and $enableThousand) or $pos==7){
    //     $translated .= $khNUMLev[$pos];			
    //     }
    //     //make addthousand to default value (false)
    //     if($pos==4){$addThousand=false;}		
    //     }
    //     //return the complete number in text
    //     return $translated;

       
    //     }
        
?>

<?php
    $msg = "";
    $number = "";
if(isset($_POST['read'])){
    $number = $_POST['number'];
    if(!is_int($number)){
        function convertNumber($num = false)
        {
            $num = str_replace(array(',', ''), '' , trim($num));
            if(! $num) {
                return false;
            }
            $num = (int) $num;
            $words = array();
            $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
                'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            );
            $list2 = array('', 'ten', 'twenty - ', 'thirty - ', 'forty - ', 'fifty - ', 'sixty - ', 'seventy - ', 'eighty - ', 'ninety - ', 'hundred');
            $list3 = array ('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
            );
            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);
            for ($i = 0; $i < count($num_levels); $i++) {
                $levels--;
                $hundreds = (int) ($num_levels[$i] / 100);
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
                $tens = (int) ($num_levels[$i] % 100);
                $singles = '';
                if ( $tens < 20 ) {
                    $tens = ($tens ? ' and ' . $list1[$tens] . ' ' : '' );
                } elseif ($tens >= 20) {
                    $tens = (int)($tens / 10);
                    $tens = ' and ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_levels[$i] % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
            } //end for loop
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }
            $words = implode(' ',  $words);
            $words = preg_replace('/^\s\b(and)/', '', $words );
            $words = trim($words);
            $words = ucfirst($words);
            $words = $words . ".";
            return $words;
        }
    }
    $convert =  convertNumber($number);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read number to string in PHP</title>
    <style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

    }
    .container_full{
        width: 100%;
        height: auto;
        border-bottom: 4px solid #f91a1a;
        background-color: #1d77bb;

    }
    .container{
        width: 80%;
        height: auto;
        margin: 0 auto;
    }
    .container h1{
        color: #fff;
        font-weight: bold;
        font-size: 20px;
        padding: 20px 0;

    }
    .fill{
        height: auto;
        background-color: #fff;
        display: flex; 
        padding: 30px;
        box-shadow: 3px 2px 5px lightgray;
        border: 1px solid #1d77bb;
        margin-top: 30px;
    }
    .form-input{
        width: 50%;
        height: auto;
        background-color: #1d77bb;
        padding: 25px;
    }
    input{
        display: block;
        padding: 10px;
        border: unset;
        outline: unset;
        width: 100%;
        margin: 15px 0;
    }
    h2{
        font-size: 19px;
        color: #fff;
        text-align: center;
        margin-bottom: 30px;
        text-shadow: 1px 2px 5px black;
    }
    button{
        padding: 8px 20px;
        border: unset;
        outline: unset;
        float: right;
        background-color: #f91a1a;
        cursor: pointer;
        transition: 0.2s;
        color: #fff;
    }
    button:hover{
        background-color: #cd0505;
    }
    .result{
        border-left: 4px solid #fff;
        background-color: #e31d1d;
    }
    p.read-result{
        color: #fff;
        font-size: 18px;
        margin: 5px 0;
    }
    </style>
</head>
<body>
    <div class="container_full">
        <div class="container">
            <h1>PHP | Read number to string</h1>
        </div>
    </div>
    <div class="container fill">
            <div class="form-input">
                <h2>Read number to string</h2>
                <form action="" method="post">
                    <!-- <label for="number">Number</label> -->
                    <input type="number" name="number" id="number" value="" placeholder="Enter number...">
                    <button type="submit" name="read">Read</button>
                </form>
            </div>

            <div class="form-input result">
                <h2>Results</h2>
                <p class="read-result"><b>Your number:</b>  <?php echo $number;?></p>
                <p class="read-result"><b>Read:</b> "<?php echo $convert?>"</p>
            </div>
        </div>
</body>
</html>
<?php
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read number to string in PHP</title>
    <style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

    }
    .container_full{
        width: 100%;
        height: auto;
        border-bottom: 4px solid #f91a1a;
        background-color: #1d77bb;

    }
    .container{
        width: 80%;
        height: auto;
        margin: 0 auto;
    }
    .container h1{
        color: #fff;
        font-weight: bold;
        font-size: 20px;
        padding: 20px 0;

    }
    .fill{
        height: auto;
        background-color: #fff;
        display: flex; 
        padding: 30px;
        box-shadow: 3px 2px 5px lightgray;
        border: 1px solid #1d77bb;
        margin-top: 30px;
    }
    .form-input{
        width: 50%;
        height: auto;
        background-color: #1d77bb;
        padding: 25px;
    }
    input{
        display: block;
        padding: 10px;
        border: unset;
        outline: unset;
        width: 100%;
        margin: 15px 0;
    }
    h2{
        font-size: 19px;
        color: #fff;
        text-align: center;
        margin-bottom: 30px;
        text-shadow: 1px 2px 5px black;
    }
    button{
        padding: 8px 20px;
        border: unset;
        outline: unset;
        float: right;
        background-color: #f91a1a;
        cursor: pointer;
        transition: 0.2s;
        color: #fff;
    }
    button:hover{
        background-color: #cd0505;
    }
    .result{
        border-left: 4px solid #fff;
        background-color: #e31d1d;
    }
    p.read-result{
        color: #fff;
        font-size: 18px;
        margin: 5px 0;
    }
    </style>
</head>
<body>
    <div class="container_full">
        <div class="container">
            <h1>PHP | Read number to string</h1>
        </div>
    </div>
    <div class="container fill">
            <div class="form-input">
                <h2>Read number to string</h2>
                <form action="" method="post">
                    <!-- <label for="number">Number</label> -->
                    <input type="number" name="number" id="number" value="" placeholder="Enter number...">
                    <button type="submit" name="read">Read</button>
                </form>
            </div>
        </div>
</body>
</html>
<?php
}
?>