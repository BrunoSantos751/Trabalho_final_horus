<?php
class UploadImagem {

    function uploadImagem($file, $pasta) {
        $extensoesPermitidas = ['jpg', 'jpeg', 'png'];

        $nomeOriginal = $file['name'];
        $tmp = $file['tmp_name'];

        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

        if (!in_array($extensao, $extensoesPermitidas)) {
            throw new Exception("Extensão não permitida");
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception("Arquivo muito grande");
        }

        $diretorio = "uploads/" . $pasta . "/";
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $novoNome = uniqid() . "." . $extensao;

        $caminho = $diretorio . $novoNome;

        if (!move_uploaded_file($tmp, $caminho)) {
            throw new Exception("Erro ao salvar imagem");
        }

        return $caminho;
    }

    public static function deleteImage($class,$id, $field) {
        $file = ['foto', 'imagem_fundo', 'imagem_secaoHome', 'imagem_AppStore', 'imagem_GooglePlay', 'imagem_secaoLojaApp', 'logo_rodape', 'favicon', 'logo_cabecalho'];

        if (!in_array($field, $file)) {
            return;
        }
        $object = $class::find($id);
        if ($object) {
            if (!empty($object[$field]) && file_exists($object[$field])) {
                unlink($object[$field]);
            }
        }
    }
}