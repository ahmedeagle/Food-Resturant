@extends('Provider.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')

    <main class="page-content py-5">

        <header class="page-header mt-2 text-center">
            <h1 class="page-title h2 font-body-bold">التصنيفات</h1>
        </header>

        <div class=" categories section-content mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="{{ url("/assets/site/img/categories/cat-1.jpg") }}"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            وجبات سريعة
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4 mt-sm-0">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-2.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            مأكولات بحرية
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4 mt-md-0">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-3.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            مأكولات شرقية
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4 mt-md-0">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-4.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            حلويات غربية
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-5.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            مأكولات يابانية
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-6.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            شوربة
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-7.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            معجنات
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-8.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            مأكولات صحية
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6 col-12 mt-4">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-1.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            وجبات سريعة
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-2.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            مأكولات بحرية
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-3.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            مأكولات شرقية
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 mt-4">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <figure class="cat-figure mb-0">
                                <img src="assets/img/categories/cat-4.jpg"
                                     class="img-fluid d-block mx-auto w-100"
                                     width="270"
                                     height="380"
                                     alt="Category image">
                                <figcaption class="cat-figcaption position-absolute px-3">
                                    <h3 class="cat-title font-body-md position-relative">
                                        <a href="category.html" class="text-white no-decoration">
                                            حلويات غربية
                                        </a>
                                    </h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div><!-- .row -->
            </div><!-- .container -->
        </div>

        <nav aria-label="Page navigation" class="d-flex justify-content-center mt-5">
            <ul class="pagination pr-0">
                <li class="page-item active">
                    <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                       href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                       href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                       href="#">3</a>
                </li>
                <span>...</span>
                <li class="page-item">
                    <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                       href="#">التالي</a>
                </li>
            </ul>
        </nav>
    </main><!-- .page-content -->

@endsection