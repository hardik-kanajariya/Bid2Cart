import React from 'react'
import Link from 'next/link';
import Counter from '../common/Counter';

export default function SingleProductCard(props) {
    return (
        <div key={props.id} className="col-lg-4 col-md-6 col-sm-10 ">
            <div data-wow-duration="1.5s" data-wow-delay="0.2s" className="eg-card auction-card wow animate fadeInDown">
                <div className="auction-img">
                    <img alt="image" src={props.thumbnail}/>
                    <div className="auction-timer p-0">
                        <div className="countdown" id="timer1">
                            <h4><Counter formate="counter1"/></h4>
                        </div>
                    </div>
                </div>
                <div className="auction-content">
                    <h4><Link href="/auction-details"><a>{props.name}</a></Link></h4>
                    <p>Bidding Price : <span><span>${props.bidPrice}</span></span></p>
                    <div className="auction-card-bttm">
                        <Link href="/auction-details"><a className="eg-btn btn--primary btn--sm">Place a Bid</a></Link>
                        <div className="share-area">
                            <ul className="social-icons d-flex">
                                <li><a href="https://www.facebook.com/"><i className="bx bxl-facebook"/></a></li>
                                <li><a href="https://www.twitter.com/"><i className="bx bxl-twitter"/></a></li>
                                <li><a href="https://www.pinterest.com/"><i className="bx bxl-pinterest"/></a></li>
                                <li><a href="https://www.instagram.com/"><i className="bx bxl-instagram"/></a></li>
                            </ul>
                            <div>
                                <div className="share-btn"><i className="bx bxs-share-alt"/></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
