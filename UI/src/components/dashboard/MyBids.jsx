import React, {useEffect, useState} from 'react'
import Counter from '../common/Counter';
import Link from 'next/link';

function MyBids() {
    const [products, setProducts] = useState([])
    useEffect(() => {
        getMyBids();
    }, [])

    async function getMyBids() {
        let headersList = {
            "Accept": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/mybids`, {
            method: "GET",
            headers: headersList
        });

        let data = await response.json();
        setProducts(data);
    }

    // function to detect is object is empty or not
    function isEmptyObject(obj) {
        return JSON.stringify(obj) === '[]';
    }

    return (
        <div className="tab-pane fade" id="v-pills-purchase" role="tabpanel" aria-labelledby="v-pills-purchase-tab">
            {/* table title*/}
            <div className="table-title-area">
                <h3>My Bids</h3>
            </div>
            {/* table */}
            <div className="row">
                {!isEmptyObject(products) ? Object.values(products).map(props => {
                    return <div key={props.prd_id} className="col-lg-4 col-md-6 col-sm-10">
                        <div data-wow-duration="1.5s" data-wow-delay="0.2s"
                             className="eg-card auction-card wow animate fadeInDown">
                            <div className="auction-img">
                                <img alt="image" src={props.thumbnail} height="300px"/>
                                <div className="auction-timer shadow-sm">
                                    <div className="countdown" id="timer1">
                                        <h4><Counter formate="counter3" date={props.end_time}/></h4>
                                    </div>
                                </div>
                            </div>
                            <div className="auction-content">
                                <h4><Link href={`/auction/${props.prd_id}/${props.title}`}><a>{props.title}</a></Link>
                                </h4>
                                <p>Current Bidding Price : <span><span>${props.current_bid}</span></span></p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                }) : (<>
                    <h2>You have not placed any bids..</h2>
                </>)}
            </div>
        </div>
    )
}

export default MyBids