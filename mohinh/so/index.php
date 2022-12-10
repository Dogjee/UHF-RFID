<?php
declare(strict_types=1);

error_reporting(-1);
ini_set('display_errors', 'On');

require_once 'src/MinQueue.php';
require_once 'src/Dijkstra.php';
require_once 'src/Maze.php';

function ghiFileKQ(string $x, string $y){
    try{
        foreach (glob('.\newfile.txt') as $file) {
            $maze = Maze::fromString(file_get_contents($file));
        
            $start = $maze->find($x);
            $goal = $maze->find($y);
        
            $helper = new Dijkstra(
                function ($a) use ($maze) {
                    return $maze->getNeighbors($a, ['1']);
                },
                function ($a, $b) use ($maze) {
                    return $maze->getDistance($a, $b);
                }
            );
        
            $tStart = microtime(true);
            $path = $helper->findPath($start, $goal);
            $tEnd = microtime(true);
        
            $mazeStrWithPath = $maze->toString(function ($tile) use ($path) {
                return in_array($tile, $path, true) && !in_array($tile->value, ['$x', '$y'])
                    ? '.'
                    : $tile->value
                ;
            });
        
            // printf("%s:\n%s\nin: %.5fs\n\n", $file, $mazeStrWithPath, $tEnd - $tStart);
            // printf("%s",$file);
            // echo $mazeStrWithPath;
            // printf("%s", $mazeStrWithPath);
            // printf(gettype($mazeStrWithPath));
            // $myfile = fopen("../ketqua.txt", "w") or die("Unable to open file!");
            // fwrite($myfile, $mazeStrWithPath);
            return $mazeStrWithPath;
        }
       }
       catch (LogicException $e){
            // header("Location:../MoHinhSachTrenKe/multiply.php");
            echo "
            <script>
            alert('Không tìm thấy sách hoặc không tìm thấy đường đi đến sách')
            </script>";
            return ;
       }
}

