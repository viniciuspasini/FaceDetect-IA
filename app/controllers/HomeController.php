<?php

namespace app\controllers;

//require_once('../stub/stub.php');

use core\library\Request;
use core\library\Response;
use core\library\Template;
use CV\CascadeClassifier;
use CV\Scalar;
use function CV\imread;
use function CV\imwrite;
use function CV\rectangleByRect;

class HomeController
{

    /**
     * @throws \Exception
     */
    public function index()
    {
        return view('home', ['title' => 'Face Detect']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function faceDetect(Request $request)
    {
        if(isset($request->files['imagem'])) {

            $arquivo = $request->files['imagem'];

            $nomeTemporario = $arquivo['tmp_name'];
            $nomeOriginal = $arquivo['name'];
            $tamanho = $arquivo['size'];
            $erro = $arquivo['error'];

            $diretorioDestino = BASE_PATH.'/public/assets/images/';

            $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
            $novoNome = uniqid() . '.' . $extensao;
            $caminhoCompleto = $diretorioDestino . $novoNome;


            if(move_uploaded_file($nomeTemporario, $caminhoCompleto)) {
                $msg = "Imagem salva com sucesso como: " . $novoNome;
            } else {
                $msg = "Erro ao salvar a imagem.";
            }

            $image = imread(BASE_PATH.'/public/assets/images/'.$novoNome);
            $faces = [];

            $classifier = new CascadeClassifier();
            $classifier->load(BASE_PATH.'/public/assets/haarcascade_frontalface_alt.xml');
            $classifier->detectMultiScale($image, $faces);

            foreach ($faces as $face) {
                rectangleByRect($image, $face, new Scalar(0,0,255), 3);
            }

            imwrite(BASE_PATH.'/public/assets/images/face_detect_'.$novoNome, $image);

            unlink(BASE_PATH.'/public/assets/images/'.$novoNome);

            //sleep(60);

        }else{
            $msg = "Erro ao salvar a imagem.";
        }

        return [
            'msg' => $msg,
            'file' => 'assets/images/face_detect_'.$novoNome
        ];
    }
}