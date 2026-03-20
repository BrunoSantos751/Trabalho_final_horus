<?php

require_once 'model/Modelbase.php';
require_once './utils/UploadImagem.php';

class Preferencias extends Modelbase
{
   protected static $tableName = "preferencias";

   public static function save($data = null)
   {
      $conn = self::getConnection();
      $data = $data ?? $_POST;

      $inputparams = [
         'titulo_landing',
         'facebook',
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
         'mensagem_rodape',
         'url_rodape',
         'mensagem_powered',
      ];

      $imgParams = ['imagem_secaoHome', 'imagem_AppStore', 'imagem_GooglePlay', 'imagem_secaoLojaApp', 'logo_rodape', 'favicon', 'logo_cabecalho'];

      $params = [];

      $isUpdate = !empty($data['id']);

      foreach ($inputparams as $param) {
         if (!empty($data[$param])) {
            $params[] = $param;
         }
      }

      foreach ($imgParams as $param) {
         if ($isUpdate ? array_key_exists($param, $data) : !empty($data[$param])) {
            $params[] = $param;
         }
      }

      $fields = [];

      if (isset($data['id']) && !empty($data['id'])) {

         foreach ($params as $param) {
            $fields[] = "$param = :$param";
         }

         $sql = "UPDATE preferencias SET " . implode(', ', $fields) . " WHERE id = :id";

      } else {
         $fieldsValue = [];

         foreach ($params as $param) {
            $fields[] = " $param";
            $fieldsValue[] = " :$param";
         }

         $sql = "INSERT INTO preferencias (" . implode(', ', $fields) . ") VALUES (" . implode(',', $fieldsValue) . " )";
      }

      $stmt = $conn->prepare($sql);
      if ($isUpdate) {
         $stmt->bindValue(':id', $data['id']);
      }

      foreach ($params as $param) {
         $val = $data[$param] ?? null;
         if (in_array($param, $imgParams)) {
            $val = $val ?: null;
         }
         $stmt->bindValue(":$param", $val);
      }

      $stmt->execute();
   }

   public static function first() {
      $conn = self::getConnection();

      $sql = "SELECT * FROM ". static::$tableName ." LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
        
   }

   // protected static function find($id=null)
   // {
   //    $conn = self::getConnection();
      
   //    $sql = "SELECT * FROM " . static::$tableName;
   //    if (empty($id)){
   //       $sql .= " WHERE id = :id"; 
   //       $stmt->bindParam(':id', $id);
   //    }
   //    $result = $conn->query($sql);
   //    return $result->fetch();
   // }

   // public static function delete($id)
   // {
   //    $conn = self::getConnection();
   //    foreach (['imagem_secaoHome', 'imagem_AppStore', 'imagem_GooglePlay', 'imagem_secaoLojaApp', 'logo_rodape', 'favicon', 'logo_cabecalho'] as $field) {
   //       UploadImagem::deleteImage(self::class, $id, $field);
   //    }
   //    return $conn->query("DELETE FROM preferencias WHERE id='{$id}'");
   // }
}
