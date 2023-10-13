<!-- Modal Create/update Book-->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Create BOOK</h5>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <form id="addnewbk" class="needs-validation" novalidate>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="imgbbookcontainer">
                                    <div class="img-container">
                                        <img id="chimg" src="booksimg/bookdefault.png" alt="book">
                                    </div>
                                    <input id="filebdata" type="file" name="file" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3 position-relative">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter ISBN" required>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid ISBN.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid title.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="author" class="form-label">Author</label>
                                    <input type="text" class="form-control" id="author" name="author" placeholder="Enter Author" required>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid author name.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" required>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid category.
                                    </div>
                                </div>
                                <div class="mb-3 ">
                                    <label for="bookprice" class="form-label">Book Price (in Pesos)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="bookprice" name="bookprice" value='0' placeholder="Enter Book Price" required>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <!-- Add validation for other input fields -->
                                <div class="mb-3 ">
                                    <label for="yearpublished" class="form-label">Year Published</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        <input type="text" class="form-control" id="yearpublished" name="yearpublished" data-toggle="datepicker" placeholder="Select Year Published" required>
                                    </div>

                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="publisher" class="form-label">Publisher</label>
                                    <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Enter Publisher" required>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid publisher.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid quantity.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="abstract" class="form-label">Abstract</label>
                                    <textarea class="form-control" id="abstract" name="abstract" placeholder="Enter Abstract" required></textarea>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid abstract.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="bookSaveBtn" class="btn btn-primary">SAVE</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                </form>

            </div>
        </div>
    </div>
</div>