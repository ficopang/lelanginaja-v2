@extends('template.generic')

@section('title', 'FAQ')

@section('content')
    <!-- Start Faq Area -->
    <section class="faq section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Haven't found the answer?<br> Ask us your question.</h2>
                        <p>We normally respond within 2 business days. Most popular questions will appear on this page.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-md-12 col-12">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="title">How does LelanginAja work?</span><i class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>LelanginAja is an auction marketplace platform where users can buy and sell products
                                        through bidding.
                                        Sellers can upload their items for auction, and buyers can place bids on the items
                                        they are interested
                                        in. The highest bidder at the end of the auction wins the item.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span class="title">How do I participate in an auction?</span><i
                                        class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>To participate in an auction, simply create an account on LelanginAja. Once
                                        registered, you can browse
                                        through the available listings and place bids on the items you want. Keep an eye on
                                        the auction
                                        progress and make sure to bid competitively to increase your chances of winning.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <span class="title">How long do the auctions last?</span><i class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>The duration of each auction is determined by the seller. Auctions can range from a
                                        few hours to several
                                        days. The remaining time for each auction is displayed on the product listing page,
                                        allowing you to keep
                                        track of the time left for bidding.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <span class="title">Can I sell my own items on LelanginAja?</span><i
                                        class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Absolutely! LelanginAja provides a platform for individuals to sell their products
                                        through auctions.
                                        Simply create a seller account, upload clear and accurate product details, set a
                                        starting price, and
                                        specify the duration of the auction. Once your item receives bids, the auction will
                                        progress until the
                                        specified end time.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <span class="title">Is bidding binding, and what happens after winning an
                                        auction?</span><i class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Bidding on LelanginAja is binding, meaning that if you place the highest bid and win
                                        the auction, you
                                        are obligated to complete the purchase. After winning an auction, you will be
                                        contacted to arrange
                                        payment and shipping details. It is important to carefully review the item
                                        description and terms before
                                        placing a bid.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <span class="title">How secure are transactions on LelanginAja?</span><i
                                        class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>LelanginAja prioritizes the security of transactions. We implement measures to
                                        protect user information
                                        and facilitate safe payment processing. However, it is always recommended to
                                        exercise caution when
                                        providing personal and financial information online.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Faq Area -->
@endsection
