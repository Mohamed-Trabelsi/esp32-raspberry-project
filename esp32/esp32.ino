#include <Adafruit_BMP085.h>
#include "PubSubClient.h" 
#include <WiFi.h>

// WiFi
const char* ssid = "Airbox-FC4A";                 // Your personal network SSID
const char* wifi_password = "3h3H2n5C"; // Your personal network password
int potpin = 35; 
// MQTT
const char* mqtt_server = "broker.emqx.io";  // IP of the MQTT broker
const char* pressure_topic = "home/livingroom/pressure";
const char* temperature_topic = "home/livingroom/temperature";
const char* altitude_topic = "home/livingroom/altitude";
const char* gaz_topic = "home/livingroom/gaz";
const char* mqtt_username = "iot"; // MQTT username
const char* mqtt_password = "iot"; // MQTT password
const char* clientID = "client_livingroom"; // MQTT client ID

// Initialise the WiFi and MQTT Client objects
WiFiClient wifiClient;
// 1883 is the listener port for the Broker
PubSubClient client(mqtt_server, 1883, wifiClient); 

void connect_MQTT(){
  Serial.print("Connecting to ");
  Serial.println(ssid);

  // Connect to the WiFi
  WiFi.begin(ssid, wifi_password);

  // Wait until the connection has been confirmed before continuing
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("WiFi connected");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

    if (client.connect(clientID, mqtt_username, mqtt_password)) {
    Serial.println("Connected to MQTT Broker!");
  }
  else {
    Serial.println("Connection to MQTT Broker failed...");
  }
}
Adafruit_BMP085 bmp;
  
void setup() {
  Serial.begin(9600);
  if (!bmp.begin()) {
	Serial.println("Could not find a valid BMP085 sensor, check wiring!");
	pinMode(potpin, INPUT);
  }
 }
  
void loop() {

connect_MQTT();
  Serial.setTimeout(2000);
  

  delay(50);
  float p = bmp.readPressure();
  float temp=bmp.readTemperature();
  float a=bmp.readAltitude();
  float  val = analogRead(potpin);

  Serial.print("Temperature: ");
  Serial.print(temp);
  Serial.println(" C");
  Serial.print("Pressure: ");
  Serial.print(p);
  Serial.println(" Pa");
  Serial.print("Altitude: ");
  Serial.print(a);
  Serial.println(" metres");
  Serial.println("pot");
  Serial.println(val);
  
  

// MQTT can only transmit strings
  String hs="Pressure: "+String((float)p)+" Pa ";
  String ts="Temp: "+String((float)temp)+" C ";
  String as="Alt: "+String((float)a)+" metres ";
  String gaz = "Gaz: "+String((float)val);

 // PUBLISH to the MQTT Broker (topic = Temperature, defined at the beginning)
  if (client.publish(temperature_topic, String(temp).c_str())) {
    Serial.println("Temperature sent!");
  }
  else {
    Serial.println("Temperature failed to send. Reconnecting to MQTT Broker and trying again");
    client.connect(clientID, mqtt_username, mqtt_password);
    delay(10); // This delay ensures that client.publish doesn't clash with the client.connect call
    client.publish(temperature_topic, String(temp).c_str());
  }
  // PUBLISH to the MQTT Broker (topic = Pressure, defined at the beginning)
  if (client.publish(pressure_topic, String(p).c_str())) {
    Serial.println("Pressure sent!");
  }
  else {
    Serial.println("Pressure failed to send. Reconnecting to MQTT Broker and trying again");
    client.connect(clientID, mqtt_username, mqtt_password);
    delay(10); // This delay ensures that client.publish doesn't clash with the client.connect call
    client.publish(pressure_topic, String(p).c_str());
  }
    if (client.publish(gaz_topic, String(val).c_str())) {
    Serial.println("Pressure sent!");
  }
  else {
    Serial.println("Pressure failed to send. Reconnecting to MQTT Broker and trying again");
    client.connect(clientID, mqtt_username, mqtt_password);
    delay(10); // This delay ensures that client.publish doesn't clash with the client.connect call
    client.publish(gaz_topic, String(val).c_str());
  }
  // PUBLISH to the MQTT Broker (topic = Altitude, defined at the beginning)
 if (client.publish(altitude_topic, String(a).c_str())) {
    Serial.println("Altitude sent!");
  }
  else {
    Serial.println("Altitude failed to send. Reconnecting to MQTT Broker and trying again");
    client.connect(clientID, mqtt_username, mqtt_password);
    delay(10); // This delay ensures that client.publish doesn't clash with the client.connect call
    client.publish(altitude_topic, String(a).c_str());
  } 

  client.disconnect();  // disconnect from the MQTT broker
  delay(1000*10);       // print new values every 1 Minute

}
