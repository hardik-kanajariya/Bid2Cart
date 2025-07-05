import React from 'react'
import Zoom from 'react-reveal/Zoom';

function About() {
    return (<div className="about-section pt-120 pb-120">
            <img src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-top" alt="section-bg"/>
            <div className="container">
                <div className="row d-flex justify-content-center g-4">
                    <div className="col-lg-6 col-md-10">
                        <div className="about-img-area">
                            <div className="total-tag">
                                <Zoom top cascade>
                                    <img src="/assets/images/bg/total-tag.png" alt=""/>
                                    <h6>Total Bids Placed</h6>
                                    <h5>$45,390.00</h5>
                                </Zoom>
                            </div>
                            <Zoom cascade>
                                <img src="/assets/images/bg/about-img.png" className="img-fluid about-img wow fadeInUp"
                                     data-wow-duration="1.5s" data-wow-delay=".2s" alt="about-img"/>
                            </Zoom>
                            <img src="/assets/images/bg/about-linear.png" className="img-fluid about-linear" alt=""/>
                            <img src="/assets/images/bg/about-vector.png" className="img-fluid about-vector" alt=""/>
                        </div>
                    </div>
                    <div className="col-lg-6 col-md-10">
                        <div className="about-content wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <Zoom cascade top>
                                <span>Who we are!</span>
                                <h1>Bid2Cart</h1>
                                <h2>Lid it, Try it, Bid it, Buy it</h2>
                                <h3>Life is Full of Auction. No Lid on the Bid. No Need to Run, Bidding is Fun.</h3>
                                <p className="para">We specialize mainly in misguided/ lost in freight liquidation.
                                    (Items that customers have purchased online from major retailers that do not get to
                                    their destination) We also get alot of new open box, overstock/ out of season/ and
                                    some like new customer returns.</p>
                                {/* <a href="#choose-us" className="eg-btn btn--primary btn--md">More About</a> */}
                            </Zoom>
                        </div>
                    </div>
                    <div className="col-lg-12 col-md-10">
                        <div className="about-content wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <Zoom top>
                                <p className="para">We specialize in selling these items at a 25%-70% discount depending
                                    on the item and time of season. </p>

                                <p className="para">We currently hold bi-weekly inventory auctions to clear our smaller
                                    inventory or any other items we are looking to clear out.</p>

                                <p className="para">Our cutting-edge software was designed to make your online shopping
                                    and auction experience as convenient and enjoyable as possible. Our software is
                                    programmed to enable our customers to bid on items in real time against our other
                                    local members with instant bid updates without having to refresh your page.</p>

                                <p className="para">Each auction usually will have between 1000-1600 items.</p>

                                <p className="para">Our products range in condition, from brand new sealed packaging, to
                                    new but open-box or distressed packaging , to refurbished, store returns, used items
                                    and finally AS-IS.</p>

                                <p className="para">We try to be as transparent and honest as possible when describing
                                    the items up for sale or auction. If there is an issue with an item, we will photo
                                    it and describe it in the condition notes. We rate all our items on a 1-6 star scale
                                    representing its condition. We also provide a generic in-stock Canadian price of the
                                    item with brief research of the major Canadian retail companies. All our retail
                                    values will be in Canadian, If an American website is used, the price would be
                                    converted from USD to CAD. We encourage all our bidders to do their own research on
                                    the items as ours are only there as a friendly retail value guideline.</p>

                                <p className="para">A 14 day in-house warranty is provided on all items unless stated
                                    AS-IS. This is to give our members peace of mind when purchasing or bidding.</p>

                                <p className="para">We are about establishing trust with all our members and look
                                    forward to a long relationship. We look forward to meeting our members. Enjoy the
                                    site!</p>

                                <p className="para">Join the club! Start Saving Today!</p>
                                {/* <a href="#choose-us" className="eg-btn btn--primary btn--md">More About</a> */}
                            </Zoom>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    )
}

export default About