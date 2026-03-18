<?php

require_once 'model/Modelbase.php';

class Preferencias extends Modelbase {

   public static function save() {
      $conn = self::getConnection();
      if (isset($_POST['id']) && !empty($_POST['id'])){
         $sql = "UPDATE Preferencias SET titulo_landing = :titulo_landing, favicon = :favicon, logo_cabecalho = :logo_cabecalho, facebook = :facebook, twitter = :twitter, instagram = :instagram, titulo_secaoHome = :titulo_secaoHome, subtitulo_secaoHome = :subtitulo_secaoHome, imagem_secaoHome = :imagem_secaoHome, titulo_caracticasHome = :titulo_caracticasHome, titulo_secaoLojaApp = :titulo_secaoLojaApp, subtitulo_secaoLojaApp = :subtitulo_secaoLojaApp, imagem_secaoLojaApp = :imagem_secaoLojaApp, image_AppStore = :image_AppStore, image_GooglePlay = :image_GooglePlay, telefone_contato = :telefone_contato, logo_rodape = :logo_rodape, mesagem_rodape = :mesagem_rodape, url_rodape = :url_rodape, mensagem_powered = :mensagem_powered WHERE id = :id";

      } 
      else {
            $sql = "INSERT INTO Preferencias (titulo_landing, favicon, logo_cabecalho, facebook, twitter, instagram, titulo_secaoHome, subtitulo_secaoHome, imagem_secaoHome, titulo_caracticasHome, titulo_secaoLojaApp, subtitulo_secaoLojaApp, imagem_secaoLojaApp, image_AppStore, image_GooglePlay, telefone_contato, logo_rodape, mesagem_rodape, url_rodape, mensagem_powered) VALUES (:titulo_landing, :favicon, :logo_cabecalho, :facebook, :twitter, :instagram, :titulo_secaoHome, :subtitulo_secaoHome, :imagem_secaoHome, :titulo_caracticasHome, :titulo_secaoLojaApp, :subtitulo_secaoLojaApp, :imagem_secaoLojaApp, :image_AppStore, :image_GooglePlay, :telefone_contato, :logo_rodape, :mesagem_rodape, :url_rodape, :mensagem_powered)";
      }

      $stmt = $conn->prepare($sql);
      if (isset($_POST['id']) && !empty($_POST['id'])){
         $stmt->bindParam(':id', $_POST['id']);
      } 
      $stmt->bindParam(':titulo_landing', $_POST['titulo_landing']);
      $stmt->bindParam(':favicon', $_POST['favicon']);
      $stmt->bindParam(':logo_cabecalho', $_POST['logo_cabecalho']);
      $stmt->bindParam(':facebook', $_POST['facebook']);
      $stmt->bindParam(':twitter', $_POST['twitter']);
      $stmt->bindParam(':instagram', $_POST['instagram']);
      $stmt->bindParam(':titulo_secaoHome', $_POST['titulo_secaoHome']);
      $stmt->bindParam(':subtitulo_secaoHome', $_POST['subtitulo_secaoHome']);
      $stmt->bindParam(':imagem_secaoHome', $_POST['imagem_secaoHome']);
      $stmt->bindParam(':titulo_caracticasHome', $_POST['titulo_caracticasHome']);
      $stmt->bindParam(':titulo_secaoLojaApp', $_POST['titulo_secaoLojaApp']);
      $stmt->bindParam(':subtitulo_secaoLojaApp', $_POST['subtitulo_secaoLojaApp']);
      $stmt->bindParam(':imagem_secaoLojaApp', $_POST['imagem_secaoLojaApp']);
      $stmt->bindParam(':image_AppStore', $_POST['image_AppStore']);
      $stmt->bindParam(':image_GooglePlay', $_POST['image_GooglePlay']);
      $stmt->bindParam(':telefone_contato', $_POST['telefone_contato']);
      $stmt->bindParam(':logo_rodape', $_POST['logo_rodape']);
      $stmt->bindParam(':mesagem_rodape', $_POST['mesagem_rodape']);
      $stmt->bindParam(':url_rodape', $_POST['url_rodape']);
      $stmt->bindParam(':mensagem_powered', $_POST['mensagem_powered']);
      $stmt->execute();
   }
   
   public static function find($id) {
      $conn = self::getConnection();
      $result = $conn->query("SELECT * FROM Preferencias WHERE id='{$id}'");
      return $result->fetch();
   }

   public static function all() {
      $conn = self::getConnection();
      $result = $conn->query("SELECT * FROM Preferencias");
      return $result->fetchAll();
   }
   public static function delete($id) {
      $conn = self::getConnection();
      return $conn->query("DELETE FROM Preferencias WHERE id='{$id}'");
   }
}
