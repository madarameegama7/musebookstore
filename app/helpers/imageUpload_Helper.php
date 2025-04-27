<?php
function uploadImage($img, $img_name, $location)
{
    $target = dirname(__DIR__, 2) . '/public' . $location . $img_name;

    return move_uploaded_file($img, $target);
}

function updateImage($old, $img, $img_name, $location)
{
    unlink($old);

    $target = dirname(__DIR__, 2) . '/public' . $location . $img_name;

    return move_uploaded_file($img, $target);
}

function deleteImage($img)
{
    if (unlink($img)) {
        return true;
    } else {
        return false;
    }
}
