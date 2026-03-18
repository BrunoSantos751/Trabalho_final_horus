<?php
class UploadImagem {

function uploadImagem($file, $pasta) {
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

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
}