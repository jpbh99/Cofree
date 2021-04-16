#pip install paho-mqtt
import paho.mqtt.publish as publish
import Adafruit_DHT
import time
import datetime	
import busio
import digitalio
import board
import adafruit_mcp3xxx.mcp3008 as MCP
from adafruit_mcp3xxx.analog_in import AnalogIn
# colocamos el channelID de nuestro canal de thingspeak
channelID="1326958"
# colocamos el api key de nuestro canal
apiKey="QAAPTUMOAJJS7YPT"
# se coloca el nombre del host que es thingspeak MQTT
mqttHost = "mqtt.thingspeak.com"
# se realiza la configuración 
# se importa ssl que es el modulo de seguridad en la capa de transporte
import ssl
#se especifica el tipo de conexión
tTransport = "websockets"
#version del protocolo de seguridad de la capa de transporte
tTLS = {'ca_certs':"/etc/ssl/certs/ca-certificates.crt",'tls_version':ssl.PROTOCOL_TLSv1}
# se selecciona el puerto
tPort = 443
# creamos el topic        
topic = "channels/" + channelID + "/publish/" + apiKey
# create the spi bus
spi = busio.SPI(clock=board.SCK, MISO=board.MISO, MOSI=board.MOSI)

# # create the cs (chip select)
cs = digitalio.DigitalInOut(board.D5)

# # create the mcp object
mcp = MCP.MCP3008(spi, cs)

# # create an analog input channel on pin 0
chan = AnalogIn(mcp, MCP.P0)
sensor=Adafruit_DHT.DHT22
pin=23
#archivo=open("humedad.txt","w")
#archivo.write("humedad"+"		"+"temperatura"+"		"+"co2") 
while True:
	humedad, temperatura = Adafruit_DHT.read_retry(sensor, pin)
	concentracion= (159.6-(((chan.voltage)/10)*133.33))
	if humedad is not None and temperatura is not None:
		print(f'temperatura={temperatura:.2f}*C Humedad={humedad:.2f}%')
		print('concentración', str(concentracion)+"ppm")
		# fecha y hora actual para la estampa de tiempo
		fecha=datetime.datetime.now()
		# modificamos el formato de la estampa de tiempo
		fecha=fecha.strftime('%Y-%m-%d-%H:%M:%S')
		print('fecha=',fecha)
		# cadena de envio
		tPayload= "field1=" + str(temperatura) + (' fecha ') + str(fecha) + (' sensor dht22') + "&field2=" + str(humedad) + (' fecha ') + str(fecha) + (' sensor dht22 ') + "&field3=" + str(concentracion) + (' fecha ') + str(fecha) + (' sensor MQ135')
		# se intenta publicar la cadena
		try:
			publish.single(topic, payload=tPayload, hostname=mqttHost, port=tPort, tls=tTLS, transport=tTransport)
		except (KeyboardInterrupt):
		    break
		time.sleep(60)
	else:
		print('fallo lectura')
	#archivo.write("\n"+str(humedad)+"%"+"	"+str(temperatura)+"°C"+"	"+str(concentracion)+"ppm")	
#archivo.close
