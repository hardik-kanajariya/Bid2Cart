import Link from 'next/link'
import React from 'react'
import Zoom from 'react-reveal/Zoom';

function HowItWork() {
    return (<div className="how-work-section pt-120 pb-120">
            <img alt="image" src="/assets/images/bg/section-bg.png" className="section-bg-top"/>
            <div className="container">
                <div className="row g-4 mb-60">
                    <div className="col-xl-6 col-lg-6">
                        <Zoom right cascade>
                            <div className="how-work-content wow fadeInUp" data-wow-duration="1.5s"
                                 data-wow-delay=".2s">
                                <span>01.</span>
                                <h3>Register Now &amp; Start Selling Your Things</h3>
                                <p className="para">Signing up for your free Bid2Cart account is easy and secure. Once
                                    you’ve completed your profile on Bid2Cart, you can begin participating in online
                                    auctions, saving items and following searches. (Note: your information is private
                                    and secure. Any credit card information added to your Bid2Cart account will not be
                                    shared with auction houses.)</p>
                                <Link href="/signup"><a className="eg-btn btn--primary btn--md">Register
                                    Account</a></Link>
                            </div>
                        </Zoom>
                    </div>
                    <Zoom left cascade>
                        <div className="col-xl-6 col-lg-6 d-flex justify-content-lg-end justify-content-center">
                            <div className="how-work-img wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                                <img alt="image" src="/assets/images/bg/how-work1.png" className="work-img"/>
                            </div>
                        </div>
                    </Zoom>
                </div>
                <div className="row g-4 mb-60">
                    <div
                        className="col-xl-6 col-lg-6 d-flex justify-content-lg-start justify-content-center order-lg-1 order-2">
                        <Zoom right cascade>
                            <div className="how-work-img wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                                <img alt="image" src="/assets/images/bg/how-work2.png" className="work-img"/>
                            </div>
                        </Zoom>
                    </div>
                    <div className="col-xl-6 col-lg-6 order-lg-2 order-1">
                        <Zoom left cascade>
                            <div className="how-work-content wow fadeInUp" data-wow-duration="1.5s"
                                 data-wow-delay=".2s">
                                <span>02.</span>
                                <h3>Place Your Bids</h3>
                                <p className="para">Each auction house handles shipping and payment differently, so
                                    before you bid, be sure to review shipping and payment policies to avoid any
                                    surprises. Also be sure to take note of the auction’s live bidding start time. This
                                    is when live bidding begins, starting with the first lot in the auction.</p>
                                <p className="para">There are two ways to bid:</p>
                                <h4>Bid2Cart Bot</h4>
                                <p className="para">You can place Maximum amount bids in advance of the live auction.
                                    Our hassle-free BidBot ensures you get the best prices. your amount is automatically
                                    be maximum bid amount. Your bid stays at the lowest minimum amount required to keep
                                    you in the lead, and increases (up to your max amount) only if another bidder places
                                    a competing bid.</p>
                                <h4>Live bidding</h4>
                                <p className="para">Your chances of winning are three times greater when you bid during
                                    the live auction. Live auctions begin at the time indicated on catalog and item
                                    pages. To bid live, simply visit the catalog or item at the indicated auction
                                    Bidding history</p>
                                <Link href="/live-auction"><a className="eg-btn btn--primary btn--md">Browse
                                    Products</a></Link>
                            </div>
                        </Zoom>
                    </div>
                </div>
                <div className="row g-4">
                    <div className="col-xl-6 col-lg-6">
                        <Zoom right cascade>
                            <div className="how-work-content wow fadeInUp" data-wow-duration="1.5s"
                                 data-wow-delay=".2s">
                                <span>03.</span>
                                <h3>Win Your Treasure</h3>
                                <p className="para">You will be automatically notified when you win an item on Bid2Cart.
                                    Following the sale, you will be able to make your shipping arrangements, and you
                                    will be invoiced by the auction house for your item. Your credit card information on
                                    Bid2Cart is never shared, so auction houses who do not accept online payments via
                                    Bid2Cart may request additional information from you.</p>
                                <Link href="/live-auction"><a className="eg-btn btn--primary btn--md">Bid Now</a></Link>
                            </div>
                        </Zoom>
                    </div>
                    <Zoom left cascade>
                        <div className="col-xl-6 col-lg-6 d-flex justify-content-lg-end justify-content-center">
                            <div className="how-work-img wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                                <img alt="image" src="/assets/images/bg/how-work3.png" className="work-img"/>
                            </div>
                        </div>
                    </Zoom>
                </div>
            </div>
        </div>

    )
}

export default HowItWork