<?php

# Helper de publicación
class publisher_mqtt {
  private function __construct() {}
  private function __destruct() {}
  private function __clone() {}

# Convierte http://f2p a /f2p
  public static function clean_uri($uri) {
    return preg_replace('/^http:\//', '', $uri);
  }

# Conectarse y enviar un mensaje
# Acepta arrays de mensajes y topicos pero cuidado porque manda todas las
# combinaciones
  public static function send($topic, $message) {
    if (!defined('MQTT_SERVER')) return ; 

# TODO permitir cambiar el puerto
    $mqtt = new phpMQTT(MQTT_SERVER, 1883, DOMAIN);

    if ($mqtt->connect()) {
      if (is_array($topic)) {
        foreach ($topic as $t) {
          if (empty($t)) continue;

          if (is_array($message)) {
            foreach ($message as $m) {
              $mqtt->publish(self::clean_uri($t), $m, 0);
# https://github.com/bluerhinos/phpMQTT/issues/8
              sleep(1);
            }
          } else {
            $mqtt->publish(self::clean_uri($t), $message, 0);
            sleep(1);
          }
        }
      } else {
        $mqtt->publish(self::clean_uri($topic), $message, 0);
      }

# Cerrar la conexión
      $mqtt->close();
    }
  }
}
