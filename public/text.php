<?php




$path = './upload';
$result = scanFile($path);
function scanFile($path) {
    global $result;
    $exts = ['.jpg','.png','.gif','.jpeg'];
    $files = scandir($path);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            if (is_dir($path . '/' . $file)) {
                scanFile($path . '/' . $file);
            } else {
                $ext = strrchr($file,'.');
                if (in_array($ext,$exts)) {
                    $result[] = $path.'/'.$file;
                }
            }
        }
    }
    echo '<pre>';
    var_dump($result);
}

die;



$file="./upload";
function list_file($date){
    //1�������ȶ�ȡ�ļ���
    $temp=scandir($date);
    //�����ļ���
    foreach($temp as $v){
        $a=$date.'/'.$v;
        if(is_dir($a)){//������ļ�����ִ��

            if($v=='.' || $v=='..'){//�ж��Ƿ�Ϊϵͳ���ص��ļ�.��..  ���������������ͼ��������ߣ���ֹ����ѭ�������
                continue;
            }
            echo "<font color='red'>$a</font>","<br/>"; //���ļ��к������
            list_file($a);//��Ϊ���ļ��������ٴε����Լ����������������ļ����µ��ļ���������
        }else{
            echo "<img src='".$a."' alt=''><br/>";
        }

    }
}
list_file($file);

