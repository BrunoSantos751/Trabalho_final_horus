<?php

require_once 'model/Modelbase.php';
require_once './utils/UploadImagem.php';

class Preferencias extends Modelbase {

   public static function save($data = null) {
      $conn = self::getConnection();
      $data = $data ?? $_POST;
      if (isset($data['id']) && !empty($data['id'])){
      
         $append_sql = "";

         foreach (['imagem_secaoHome', 'secao_AppSore', 'imagem_Google', 'imagem_secaoLojaApp'] as $img) {
            if (!empty($data[$img]))
            $append_sql .= "$img = :$img,";
         }

         $sql = "UPDATE Preferencias SET titulo_landing = :titulo_landing, favicon = :favicon, logo_cabecalho = :logo_cabecalho, facebook = :facebook, twitter = :twitter, instagram = :instagram, titulo_secaoHome = :titulo_secaoHome, subtitulo_secaoHome = :subtitulo_secaoHome, titulo_caracticasHome = :titulo_caracticasHome, titulo_secaoLojaApp = :titulo_secaoLojaApp, subtitulo_secaoLojaApp = :subtitulo_secaoLojaApp" . ($append_sql ? ", $append_sql" : "") . " link_AppStore = :link_AppStore, link_GooglePlay = :link_GooglePlay, telefone_contato = :telefone_contato, logo_rodape = :logo_rodape, mensagem_rodape = :mensagem_rodape, url_rodape = :url_rodape, mensagem_powered = :mensagem_powered WHERE id = :id";

         var_dump($sql);
         var_dump($data);

      }else {
         }
         $sql = "INSERT INTO Preferencias (titulo_landing, favicon, logo_cabecalho, facebook, twitter, instagram, titulo_secaoHome, subtitulo_secaoHome, titulo_caracticasHome, titulo_secaoLojaApp, subtitulo_secaoLojaApp, imagem_secaoHome, imagem_secaoLojaApp, imagem_AppStore, imagem_GooglePlay, link_AppStore, link_GooglePlay, telefone_contato, logo_rodape, mensagem_rodape, url_rodape, mensagem_powered) VALUES (:titulo_landing, :favicon, :logo_cabecalho, :facebook, :twitter, :instagram, :titulo_secaoHome, :subtitulo_secaoHome,  :titulo_caracticasHome, :titulo_secaoLojaApp, :subtitulo_secaoLojaApp, :imagem_secaoHome, :imagem_secaoLojaApp, :imagem_AppStore, :imagem_GooglePlay, :link_AppStore, :link_GooglePlay, :telefone_contato, :logo_rodape, :mensagem_rodape, :url_rodape, :mensagem_powered)";

      $stmt = $conn->prepare($sql);
      if (isset($data['id']) && !empty($data['id'])){
         $stmt->bindValue(':id', $data['id']);
      }

      $stmt->bindValue(':imagem_secaoHome', $data['imagem_secaoHome'] ?? null);
      $stmt->bindValue(':titulo_landing', $data['titulo_landing'] ?? null);
      $stmt->bindValue(':favicon', $data['favicon'] ?? null);
      $stmt->bindValue(':logo_cabecalho', $data['logo_cabecalho'] ?? null);
      $stmt->bindValue(':facebook', $data['facebook'] ?? null);
      $stmt->bindValue(':twitter', $data['twitter'] ?? null);
      $stmt->bindValue(':instagram', $data['instagram'] ?? null);
      $stmt->bindValue(':titulo_secaoHome', $data['titulo_secaoHome'] ?? null);
      $stmt->bindValue(':subtitulo_secaoHome', $data['subtitulo_secaoHome'] ?? null);
      $stmt->bindValue(':titulo_caracticasHome', $data['titulo_caracticasHome'] ?? null);
      $stmt->bindValue(':titulo_secaoLojaApp', $data['titulo_secaoLojaApp'] ?? null);
      $stmt->bindValue(':subtitulo_secaoLojaApp', $data['subtitulo_secaoLojaApp'] ?? null);
      $stmt->bindValue(':link_AppStore', $data['link_AppStore'] ?? null);
      $stmt->bindValue(':link_GooglePlay', $data['link_GooglePlay'] ?? null);
      

      foreach (['imagem_secaoHome', 'imagem_AppStore', 'imagem_GooglePlay', 'imagem_secaoLojaApp'] as $img) {
         $stmt->bindValue(":$img", $data[$img] ?? null);
         if (!empty($data[$img])) {
            UploadImagem::deleteImage(self::class, $data['id'], $img);
         }
      }

      $stmt->bindValue(':telefone_contato', $data['telefone_contato'] ?? null);
      $stmt->bindValue(':logo_rodape', $data['logo_rodape'] ?? null);
      $stmt->bindValue(':mensagem_rodape', $data['mensagem_rodape'] ?? null);
      $stmt->bindValue(':url_rodape', $data['url_rodape'] ?? null);
      $stmt->bindValue(':mensagem_powered', $data['mensagem_powered'] ?? null);

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
      foreach (['imagem_secaoHome', 'imagem_secaoLojaApp', 'imagem_AppStore', 'imagem_GooglePlay'] as $field) {
         UploadImagem::deleteImage(self::class, $id, $field);
      }
      return $conn->query("DELETE FROM Preferencias WHERE id='{$id}'");
   }
}
