const mqtt = require('mqtt')
const client = mqtt.connect("mqtt://broker.emqx.io")
const topicpre='home/livingroom/pressure'
const topicName = 'home/livingroom/temperature'
const topicGaz = 'home/livingroom/gaz'
const topicAlt = 'home/livingroom/altitude'
let temp 
let press
let gaz
let alt

// connect to same client and subscribe to same topic name 
client.on('connect', () => {
    // can also accept objects in the form {'topic': qos}
  client.subscribe(topicName, (err, granted) => {
      if(err) {
          console.log(err, 'err');
      }
 })
 client.subscribe(topicpre, (err, granted) => {
      if(err) {
          console.log(err, 'err');
      }
   
  })

client.subscribe(topicGaz, (err, granted) => {
      if(err) {
          console.log(err, 'err');
      }
   
  })

client.subscribe(topicAlt, (err, granted) => {
      if(err) {
          console.log(err, 'err');
      }

  })

})


// on receive message event, log the message to the console
client.on('message', (topic, message, packet) => {
  //console.log(packet,packet.payload.toString());
  if(topic === topicName) {
    temp = JSON.parse(message);
//console.log(temp);
 
  }

  if(topic === topicpre) {
    press = JSON.parse(message);
//console.log(press);

  }
if(topic === topicGaz) {
    gaz = JSON.parse(message);
console.log(gaz);

}

if(topic === topicAlt) {
    alt = JSON.parse(message);
//console.log(gaz);

}

console.log(JSON.parse(message));
const mysql = require('mysql2');

const con = mysql.createConnection({
  host: "192.168.1.111",
  user: "root",
  password: "",
  database: "chart"
});

con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
  var sql = "INSERT INTO grandeur (temp, press, gaz,alt) VALUES ("+temp+", "+press+","+gaz+","+alt+")";

con.query(sql, function (err, result) {
    if (err) throw err;
    console.log("1 record inserted");
  });

});

})