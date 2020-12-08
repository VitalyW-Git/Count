<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<?php
ini_set('error_reporting', E_ALL);

class Button {

    private $comment = '';
    private $status = false;
    private $counter;

    function __construct(string $comment, Counter $cnt ) {
        $this->comment = $comment;
        $this->counter = $cnt; // пердаём объект класса Counter
    }
    function switch( ) {
        $this->status ^= true;
        $this->counter->reg( $this->status, $this->comment );
    }
    function show() {
        echo strftime('%X') . ' => ' . $this->comment . ' : ' . ($this->status ? 'Включить' : 'Выключить') . '!<br>';
    }
}

class Counter
{
    private $start_time = [];
    private $summary_sec = [];
    private $all_summary_sec = 0;

    /**
     * @param bool $status true and false
     * @param string $comment
     */
    function reg(bool $status, string $comment) {
        if( $status === true ) {
            $this->start_time[ $comment ] = time();
        } else {
                $diff_sec = time() - $this->start_time[ $comment ];
                @$this->summary_sec[ $comment ] += $diff_sec;
                $this->all_summary_sec += $diff_sec;
            }
        }

    function show() {
        foreach ( $this->summary_sec as $comment => $sec )
            echo "Время работы '{$comment}' : {$sec} секунд<br>";
        echo "Общее время работы {$this->all_summary_sec} секунд<br>";
    }
}




$cnt = new Counter( );
$btn1 = new Button( 'выключатель в прихожей', $cnt );
$btn2 = new Button( 'выключатель в гостинной', $cnt );

$btn1->switch();
$btn1->show();
sleep( rand( 2, 5 ) ); // задержка времени

$btn2->switch();
$btn2->show();
sleep( rand( 2, 5 ) );

$btn1->switch();
$btn2->switch();

$btn1->show();
$btn2->show();
$cnt->show();

?>

</body>
</html>
