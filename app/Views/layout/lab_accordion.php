<link rel="stylesheet" href="assets/css/lab.css">

<div class="lab-wrapper">
    <small style="opacity:.7">Nhấn vào từng buổi để xem danh sách file thực hành</small>

    <button class="lab-toggle" onclick="toggleLab()">📘 LAB THỰC HÀNH</button>

    <div class="lab-panel" id="labPanel">
        <p><b>Các buổi:</b></p>

        <?php for ($i = 2; $i <= 8; $i++): ?>
            <div class="lab-item">

                <div class="lab-title" onclick="toggleBuoi(<?= $i ?>)">
                    ▶ Buổi <?= $i ?>
                </div>

                <div class="lab-buoi" id="buoi<?= $i ?>">

                    <?php
                    $folderPath = dirname(__DIR__, 3) . "/lab/Buoi {$i}";


                    if (is_dir($folderPath)) {

                        $files = scandir($folderPath);
                        $hasFile = false;

                        echo "<ul>";

                        foreach ($files as $file) {
                            if ($file === '.' || $file === '..') continue;

                            $hasFile = true;

                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            switch ($ext) {
                                case 'php':  $icon = '🐘'; break;
                                case 'html': $icon = '🌐'; break;
                                case 'pdf':  $icon = '📕'; break;
                                case 'rar':  $icon = '📦'; break;
                                case 'txt':  $icon = '📄'; break;
                                case 'png':
                                case 'jpg':
                                case 'jpeg': $icon = '🖼'; break;
                                default:     $icon = '📁';
                            }

                            $fileUrl = BASE_URL . "/lab/open?buoi={$i}&file=" . urlencode($file);

                            echo "
                                <li class='lab-file'>
                                    <a href='{$fileUrl}' target='_blank'>
                                        {$icon} {$file}
                                    </a>
                                </li>
                            ";
                        }

                        echo "</ul>";

                        if (!$hasFile) echo "<i>Thư mục trống</i>";

                    } else {
                        echo "<i>Chưa có thư mục Buổi {$i}</i>";
                    }
                    ?>

                </div>
            </div>
        <?php endfor; ?>

        <hr>
        <p><b>Sinh viên:</b> Nguyễn Gia Huy - DH52200778</p>
        <p><b>Lớp:</b> D22_TH11</p>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/lab.js"></script>
