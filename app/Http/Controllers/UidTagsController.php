<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\Configure\TTYConfigure;

class UidTagsController extends Controller
{
    public function index()
    {
		/* $fp =fopen("com3", "w");
		 dd($fp);
		fwrite($fp, chr(a));
		fclose($fp);*/

/*$file = fopen("com3","r");

while(! feof($file))
  {
  echo fgets($file). "<br />";
  }

fclose($file);
		
    }*/

	/* $serial = new PhpSerial();
	//this is the port where my Arduino is. Check from the Arduino IDE to see yours!
	$serial->deviceSet("/dev/ttyACM0");
	$serial->confBaudRate(9600);
	$serial->confParity("none");
	$serial->confCharacterLength(8);
	$serial->confStopBits(1);
	$serial->confFlowControl("none");
	$serial->deviceOpen();*/
/*	$serialPort = new SerialPort(new SeparatorParser(), new TTYConfigure());
	$serialPort->open("/dev/ttyACM0");
	while ($data = $serialPort->read()) {
			echo $data."\n";
			if ($data === "OK") {
				$serialPort->write("1\n");
				$serialPort->close();
			}
		}*/

		//return view('nodejsserial.serial');
$serialPort = new SerialPort(new SeparatorParser(), new TTYConfigure());
//$serialPort->open("/dev/ttyACM3");
$serialPort->open("com3");
while ($data = $serialPort->read()) {
echo $data."\n";
if ($data === "OK") {
$serialPort->write("1\n");
$serialPort->close();
}
}

	}
}
