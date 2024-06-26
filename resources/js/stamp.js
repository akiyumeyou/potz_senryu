function calculateYPosition(canvas, position, size) {
    const height = canvas.height;
    switch (position) {
        case "top":
            return 20 + parseInt(size);  // テキストサイズを考慮したオフセットを追加
        case "center":
            return (height / 2) + (parseInt(size) / 2);  // 中央に配置するための調整
        case "bottom":
            return height - 20;  // 下部に配置し、オフセットを引く
        default:
            return 20 + parseInt(size);
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('preview-canvas');
    const ctx = canvas.getContext('2d');
    const imageInput = document.getElementById('image');
    const dropArea = document.getElementById('drop-area');
    const fileNameContainer = document.getElementById('file-name');
    const generatedImage = document.getElementById('generated-image');
    const fileNamePreview = document.getElementById('file-name-preview');
    let img = null;
    let originalFileName = '';

    // 画像ファイルが選択された時の処理
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            originalFileName = file.name.split('.').slice(0, -1).join('.');
            const reader = new FileReader();
            reader.onload = function(event) {
                img = new Image();
                img.onload = function() {
                    // 画像を320x440ピクセルにリサイズして描画
                    canvas.width = 320;
                    canvas.height = 440;
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
            fileNameContainer.textContent = "選択されたファイル: " + file.name;
        } else {
            fileNameContainer.textContent = "選択されたファイルは画像ではありません。";
        }
    });

    // ドラッグアンドドロップイベントの設定
    ['dragover', 'dragenter', 'dragleave', 'dragend', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, function(e) {
            e.preventDefault();
            if (['dragover', 'dragenter'].includes(eventName)) {
                dropArea.classList.add('active');
            } else {
                dropArea.classList.remove('active');
            }

            if (eventName === 'drop' && e.dataTransfer.files.length) {
                imageInput.files = e.dataTransfer.files;
                const event = new Event('change');
                imageInput.dispatchEvent(event);
            }
        }, false);
    });

    // クリックでファイル選択
    dropArea.addEventListener('click', function() {
        imageInput.click();
    });

    // テキスト反映ボタンが押された時の処理
    document.getElementById('stamp-form').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!img) {
            alert("先に画像を選択してください。");
            return;
        }

        const dataURL = canvas.toDataURL('image/png');
        const binary = atob(dataURL.split(',')[1]);
        const array = [];
        for (let i = 0; i < binary.length; i++) {
            array.push(binary.charCodeAt(i));
        }
        const file = new Blob([new Uint8Array(array)], { type: 'image/png' });
        const formData = new FormData(this);
        formData.append('image', file, `${originalFileName}.png`);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            // JSONとしてパースを試みる
            return response.json().catch(error => {
                throw new Error('Failed to parse JSON: ' + error.message);
            });
        })
        .then(data => {
            if (data.success) {
                // リダイレクトURLを処理
                window.location.href = data.redirect_url;
            } else {
                alert('スタンプの作成に失敗しました。 ' + data.message);
            }
        })
        .catch(error => {
            console.error('エラーが発生しました:', error);
            alert('スタンプの作成に失敗しました。 ' + error.message);
        });
    });


});
