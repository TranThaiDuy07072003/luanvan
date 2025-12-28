<h3>DEMO THÊM DANH MỤC (HỘI ĐỒNG)</h3>

<form action="{{ route('demo.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Tên danh mục:</label>
        <input type="text" name="name" placeholder="Nhập tên...">
    </div>

    <div style="margin-top: 10px;">
        <label>Mô tả:</label>
        <textarea name="description"></textarea>
    </div>

    <div>
        <label>Ảnh:</label>
        <input type="file" name="image">
    </div>

    <button type="submit" style="margin-top: 10px;">Lưu Danh Mục</button>
</form>
