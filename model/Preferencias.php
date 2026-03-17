<?php

require_once 'Modelbase.php';

class Preferencias extends ModelBase {


/*
CREATE TABLE IF NOT EXISTS Preferencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo_landing VARCHAR(255) NOT NULL,
    favicon VARCHAR(255) NOT NULL,
    logo_cabecalho VARCHAR(255) NOT NULL,
    facebook VARCHAR(255) NOT NULL,
    twitter VARCHAR(255) NOT NULL,
    instagram VARCHAR(255) NOT NULL,
    titulo_secaoHome VARCHAR(255) NOT NULL,
    subtitulo_secaoHome TEXT NOT NULL,
    imagem_secaoHome VARCHAR(255) NOT NULL,
    titulo_caracticasHome VARCHAR(255) NOT NULL,
    titulo_secaoLojaApp VARCHAR(255) NOT NULL,
    subtitulo_secaoLojaApp TEXT NOT NULL,
    imagem_secaoLojaApp VARCHAR(255) NOT NULL,
    image_AppStore VARCHAR(255) NOT NULL,
    image_GooglePlay VARCHAR(255) NOT NULL,
    telefone_contato VARCHAR(25) NOT NULL,
    logo_rodape VARCHAR(255) NOT NULL,
    mesagem_rodape TEXT NOT NULL,
    url_rodape VARCHAR(255) NOT NULL,
    mensagem_powered TEXT NOT NULL
*/


   public static function save($data) {
    $conn = self::getConnection();
    $result = $conn->query("SELECT max(id) as next FROM preferencias");
    if ($result){ 
      $sql = "UPDATE preferencias SET titulo_landing = :titulo_landing, favicon = :favicon, logo_cabecalho = :logo_cabecalho, facebook = :facebook, twitter = :twitter, instagram = :instagram, titulo_secaoHome = :titulo_secaoHome, subtitulo_secaoHome = :subtitulo_secaoHome, imagem_secaoHome = :imagem_secaoHome, titulo_caracticasHome = :titulo_caracticasHome, titulo_secaoLojaApp = :titulo_secaoLojaApp, subtitulo_secaoLojaApp = :subtitulo_secaoLojaApp, imagem_secaoLojaApp = :imagem_secaoLojaApp, image_AppStore = :image_AppStore, image_GooglePlay = :image_GooglePlay, telefone_contato = :telefone_contato, logo_rodape = :logo_rodape, mesagem_rodape = :mesagem_rodape, url_rodape = :url_rodape, mensagem_powered = :mensagem_powered WHERE id = :id";
    }
    else {
      $sql = "INSERT INTO preferencias (titulo_landing, favicon, logo_cabecalho, facebook, twitter, instagram, titulo_secaoHome, subtitulo_secaoHome, imagem_secaoHome, titulo_caracticasHome, titulo_secaoLojaApp, subtitulo_secaoLojaApp, imagem_secaoLojaApp, image_AppStore, image_GooglePlay, telefone_contato, logo_rodape, mesagem_rodape, url_rodape, mensagem_powered) VALUES (:titulo_landing, :favicon, :logo_cabecalho, :facebook, :twitter, :instagram, :titulo_secaoHome, :subtitulo_secaoHome, :imagem_secaoHome, :titulo_caracticasHome, :titulo_secaoLojaApp, :subtitulo_secaoLojaApp, :imagem_secaoLojaApp, :image_AppStore, :image_GooglePlay, :telefone_contato, :logo_rodape, :mesagem_rodape, :url_rodape, :mensagem_powered)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulo_landing', $data['titulo_landing']);
    $stmt->bindParam(':favicon', $data['favicon']);
    $stmt->bindParam(':logo_cabecalho', $data['logo_cabecalho']);
    $stmt->bindParam(':facebook', $data['facebook']);
    $stmt->bindParam(':twitter', $data['twitter']);
    $stmt->bindParam(':instagram', $data['instagram']);
    $stmt->bindParam(':titulo_secaoHome', $data['titulo_secaoHome']);
    $stmt->bindParam(':subtitulo_secaoHome', $data['subtitulo_secaoHome']);
    $stmt->bindParam(':imagem_secaoHome', $data['imagem_secaoHome']);
    $stmt->bindParam(':titulo_caracticasHome', $data['titulo_caracticasHome']);
    $stmt->bindParam(':titulo_secaoLojaApp', $data['titulo_secaoLojaApp']);
    $stmt->bindParam(':subtitulo_secaoLojaApp', $data['subtitulo_secaoLojaApp']);
    $stmt->bindParam(':imagem_secaoLojaApp', $data['imagem_secaoLojaApp']);
    $stmt->bindParam(':image_AppStore', $data['image_AppStore']);
    $stmt->bindParam(':image_GooglePlay', $data['image_GooglePlay']);
    $stmt->bindParam(':telefone_contato', $data['telefone_contato']);
    $stmt->bindParam(':logo_rodape', $data['logo_rodape']);
    $stmt->bindParam(':mesagem_rodape', $data['mesagem_rodape']);
    $stmt->bindParam(':url_rodape', $data['url_rodape']);
    $stmt->bindParam(':mensagem_powered', $data['mensagem_powered']);
    $stmt->execute();
   }
   
   public static function find($id) {
      $conn = self::getConnection();
      $result = $conn->query("SELECT * FROM preferencias WHERE id='{$id}'");
      return $result->fetch();
   }

   public static function all() {
      $conn = self::getConnection();
      $result = $conn->query("SELECT * FROM preferencias");
      return $result->fetchAll();
   }
   public static function delete($id) {
      $conn = self::getConnection();
      return $conn->query("DELETE FROM preferencias WHERE id='{$id}'");
   }
}
