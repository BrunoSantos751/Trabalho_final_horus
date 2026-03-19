<?php

require_once 'model/Modelbase.php';
require_once './utils/UploadImagem.php';

class Preferencias extends Modelbase {

   public static function save($data = null) {
      $conn = self::getConnection();
      $data = $data ?? $_POST;

      $inputparams = [
         'titulo_landing',
         'facebook',
         'twitter',
         'instagram',
         'titulo_secaoHome',
         'subtitulo_secaoHome',
         'titulo_caracticasHome',
         'titulo_testemunhos',
         'titulo_secaoLojaApp',
         'subtitulo_secaoLojaApp',
         'link_AppStore',
         'link_GooglePlay',
         'telefone_contato',
         'logo_rodape',
         'mensagem_rodape',
         'url_rodape',
         'mensagem_powered',
      ];

      $imgParams = ['imagem_secaoHome', 'imagem_AppStore', 'imagem_GooglePlay', 'imagem_secaoLojaApp', 'logo_rodape', 'favicon', 'logo_cabecalho'];

      $params = [];

      foreach (array_merge($inputparams, $imgParams) as $param) {
         if (!empty($data[$param])) {
            $params[] = $param;
         }
      }

      $fields = [];

      if (isset($data['id']) && !empty($data['id'])){

         foreach ($params as $param) {
            $fields[] = "$param = :$param";
         }

         $sql = "UPDATE Preferencias SET " . implode(', ', $fields) . " WHERE id = :id";

      }else{
         $fieldsValue = []; 

         foreach ($params as $param) {
               $fields[] = " $param";
               $fieldsValue[] = " :$param";
         }

         $sql = "INSERT INTO Preferencias (" . implode(', ', $fields) . ") VALUES (" . implode(',',$fieldsValue) ." )";
      }



      $stmt = $conn->prepare($sql);
      if (isset($data['id']) && !empty($data['id'])){
         foreach ($inputparams as $input) {
            $value = $data[$input] ?? null;
            if (!empty($value)) {
                  $stmt->bindValue(":$input", $value);
            }
         }

         foreach ($imgParams as $img) {
            $value = $data[$img] ?? null;
            if (!empty($value)) { 
                  $stmt->bindValue(":$img", $value);
                  UploadImagem::deleteImage(self::class, $data['id'], $img);
            }
         }
      }else{
         foreach ($params as $input) {
            $stmt->bindValue(":$input", $data[$input] ?? null);
         }
      }

      $stmt->execute();
   }
   
   public static function find() {
      $conn = self::getConnection();
      $result = $conn->query("SELECT * FROM Preferencias Limit 1");
      return $result->fetch();
   }

   public static function all() {
      $conn = self::getConnection();
      $result = $conn->query("SELECT * FROM Preferencias");
      return $result->fetchAll();
   }
   
   public static function delete($id) {
      $conn = self::getConnection();
      foreach (['imagem_secaoHome', 'imagem_AppStore', 'imagem_GooglePlay', 'imagem_secaoLojaApp', 'logo_rodape', 'favicon', 'logo_cabecalho'] as $field) {
         UploadImagem::deleteImage(self::class, $id, $field);
      }
      return $conn->query("DELETE FROM Preferencias WHERE id='{$id}'");
   }
}
