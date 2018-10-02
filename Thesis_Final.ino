#include <OneWire.h>
#include <SoftwareSerial.h>
//------------------WIFI VALUES------------------------
SoftwareSerial esp8266(2, 3); // 2 = RX, 3 = TX
String ssid = "ScoobyDooby Network";
String password = "rapperjj20";
String server = "192.168.1.2"; //ip address of localhost
String uri = "/live_charts/InsertData.php";
String data;
//------------------WIFI VALUES END--------------------

//------------------PH VALUES START------------------
#define SensorPin A0            //pH meter Analog output to Arduino Analog Input 2
#define Offset 0.20          //deviation compensate
unsigned long int avgValue;  //Store the average value of the sensor feedback
float b;
int buf[10], temp;
static float phValue;

//------------------PH VALUES END--------------------

//------------------TEMP VALUES START------------------
int DS18S20_Pin = 8; //DS18S20 Signal pin on digital 7
OneWire ds(DS18S20_Pin);  // on digital pin 7
float temperature;
//------------------TEMP VALUES END--------------------

//------------------TURBIDITY VALUES START------------------
int analogPin = 1;
int turbidity;
//------------------TURBIDITY VALUES END--------------------

unsigned long previousMillis = 0;
const long interval = 1000;


void resetWifi() {

  esp8266.println("AT+RST");

  delay(2000);

  if (esp8266.find("OK") )
    Serial.println("Module Reset");

}

void connectWifi() {
  delay(2000);

  esp8266.println("AT+CWMODE=1");
  esp8266.println("AT+CIPMODE=0");
  esp8266.println("AT+CIPMUX=1");
  String cmd = "AT+CWJAP=\"" + ssid + "\",\"" + password + "\"";
  esp8266.println(cmd);

  delay(4000);
  if (esp8266.find("OK")) {

    Serial.println("Connected!");
    delay(1000);
  }
  else {
    Serial.println("Not connected!");
    connectWifi();
  }
}


void setup() {
  Serial.begin(9600);
  esp8266.begin(115200);
  resetWifi();
  connectWifi();

}
void httppost() {

  esp8266.println("AT+CIPSTART=\"TCP\",\"" + server + "\",80");//start a TCP connection.
  delay(3000);
  if ( esp8266.find("OK")) {

    Serial.println("TCP connection ready");

  }
  String postRequest =
    "POST " + uri + " HTTP/1.0\r\n" +
    "Host: " + server + "\r\n" +
    "Accept: *" + "/" + "*\r\n" +
    "Content-Length: " + data.length() + "\r\n" +
    "Content-Type: application/x-www-form-urlencoded\r\n" +
    "\r\n" + data;

  String sendCmd = "AT+CIPSEND=";//determine the number of caracters to be sent.
  esp8266.print(sendCmd);
  esp8266.println(postRequest.length());

  delay(500);

  if (esp8266.find(">")) {
    Serial.println("Sending...");
    esp8266.print(postRequest);

    if (esp8266.find("OK")) {
      Serial.println("Packet sent");


      while (esp8266.available()) {
        String tmpResp = esp8266.readString();

        Serial.println(tmpResp);
      }
      // close the connection
      esp8266.println("AT+CIPCLOSE");
    }
  }
}

  //------------------PH METER CODES START------------------
void ph() {


  for (int i = 0; i < 10; i++) //Get 10 sample value from the sensor for smooth the value
  {
    buf[i] = analogRead(SensorPin);
    delay(10);
  }
  for (int i = 0; i < 9; i++) //sort the analog from small to large
  {
    for (int j = i + 1; j < 10; j++)
    {
      if (buf[i] > buf[j])
      {
        temp = buf[i];
        buf[i] = buf[j];
        buf[j] = temp;
      }
    }
  }
  avgValue = 0;
  for (int i = 2; i < 8; i++)               //take the average value of 6 center sample
    avgValue += buf[i];
  phValue = (float)avgValue * 5.0 / 1024 / 6; //convert the analog into millivolt
  phValue = 3.5 * phValue + Offset;                  //convert the millivolt into pH value
  //Serial.print("    pH:");
  //Serial.print(phValue);
  //Serial.println(" ");

  //delay(5000);
}
//------------------PH METER CODES END--------------------

//------------------TEMP METER CODES START------------------
float getTemp() {
  //returns the temperature from one DS18S20 in DEG Celsius

  byte data[12];
  byte addr[8];

  if ( !ds.search(addr)) {
    //no more sensors on chain, reset search
    ds.reset_search();
    return -1000;
  }

  if ( OneWire::crc8( addr, 7) != addr[7]) {
    Serial.println("CRC is not valid!");
    return -1000;
  }

  if ( addr[0] != 0x10 && addr[0] != 0x28) {
    Serial.print("Device is not recognized");
    return -1000;
  }

  ds.reset();
  ds.select(addr);
  ds.write(0x44, 1); // start conversion, with parasite power on at the end

  byte present = ds.reset();
  ds.select(addr);
  ds.write(0xBE); // Read Scratchpad


  for (int i = 0; i < 9; i++) { // we need 9 bytes
    data[i] = ds.read();
  }

  ds.reset_search();

  byte MSB = data[1];
  byte LSB = data[0];

  float tempRead = ((MSB << 8) | LSB); //using two's compliment
  float TemperatureSum = tempRead / 16;

  return TemperatureSum;
 // delay(5000);
}

//------------------TEMP METER CODES END--------------------


//------------------TURBIDITY METER CODES START------------------
int turb(){
   int turbidity = analogRead(analogPin);// read the input on analog pin 0:
// float voltage = turbidity * (5.0 / 1024.0); // Convert the analog reading (which goes from 0 - 1023) to a voltage (0 - 5V):
   Serial.println(turbidity); // print out the value you read.
   return turbidity;
   //delay(5000);
}
//------------------TURBIDITY METER CODES END--------------------


void loop() {
  ph();
  float temperature = getTemp();
  int turbidity = turb();
  

  //------------------Convert the bit data to string form--------------------
  String phValue1 = String(phValue);
  String tempValue1 = String(temperature);
  String turbValue1 = String(turbidity);
  unsigned long currentMillis = millis();
  
  Serial.print("pH Level: ");
  Serial.println(phValue1);

  Serial.print("Temperature Level: ");
  Serial.println(tempValue1);

  Serial.print("Turbidity Level: ");
  Serial.println(turbValue1);


  data = "x=" + phValue1 + "-" + tempValue1 + "-" + turbValue1 ; // data sent must be under this form //name1=value1&name2=value2.
  Serial.print("DATA to be sent: ");
  Serial.println(data);
  Serial.println();

  
  if (currentMillis - previousMillis >= interval) {
    // save the last time you blinked the LED
    previousMillis = currentMillis;

    httppost();
  //delay(5000);
  //------------------Conversion ends----------------------------------------
}
}
