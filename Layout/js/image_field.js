/**
 * initImageField
 * Adds live-preview and remove-button logic to an image input.
 *
 * @param {string} fileInputId  - id of the <input type="file">
 * @param {string} hiddenInputId - id of the <input type="hidden"> that stores saved path
 * @param {string} previewContainerId - id of the <div> where preview & remove btn render
 * @param {string} existingPath - server path already saved (populated by PHP via template)
 */
function initImageField(fileInputId, hiddenInputId, previewContainerId, existingPath) {
    var fileInput      = document.getElementById(fileInputId);
    var hiddenInput    = document.getElementById(hiddenInputId);
    var previewWrapper = document.getElementById(previewContainerId);

    if (!fileInput || !previewWrapper) return;

    // Render the current state (existing server image or nothing)
    renderPreview(existingPath ? existingPath : null, false);

    // When user selects a new file, show local preview
    fileInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) { renderPreview(e.target.result, true); };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function renderPreview(src, isLocalBlob) {
        previewWrapper.innerHTML = '';
        if (!src) return;

        var container = document.createElement('div');
        container.style.cssText = 'display:flex;align-items:center;gap:10px;margin-top:6px;';

        var img = document.createElement('img');
        img.src = src;
        img.style.cssText = 'max-width:120px;max-height:80px;object-fit:contain;border:1px solid #ccc;border-radius:4px;padding:2px;';

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = '✕ Remover';
        btn.style.cssText = 'background:#dc3545;color:#fff;border:none;padding:4px 10px;border-radius:4px;cursor:pointer;font-size:12px;align-self:center;';
        btn.addEventListener('click', function () {
            // Clear file input
            fileInput.value = '';
            // Clear saved path
            hiddenInput.value = '';
            // Remove preview
            previewWrapper.innerHTML = '';
        });

        container.appendChild(img);
        container.appendChild(btn);
        previewWrapper.appendChild(container);
    }
}
