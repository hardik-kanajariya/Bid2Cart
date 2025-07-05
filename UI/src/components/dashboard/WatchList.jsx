import axios from 'axios';
import Link from 'next/link'
import React, {useEffect, useState} from 'react'
import Counter from '../common/Counter'
import {toast} from "react-toastify";

function WatchList() {
    const [products, setProducts] = useState([])
    const [isLoaded, setIsLoaded] = useState(false)
    useEffect(() => {
        getWatchlist().then(r => setIsLoaded(true))
    }, [])

    async function getWatchlist() {
        let headersList = {
            "Accept": "application/json", "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/watchlist`, {
            method: "GET", headers: headersList
        });
        let data = await response.json();
        setProducts(data);
    }

    // Function to remove wishlist
    function removeWatchList(id) {
        let body = {
            "pid": id,
        }
        axios.post(`${process.env.NEXT_PUBLIC_API_URL}/api/watchlist/remove`, body, {
            headers: {
                'Content-Type': 'application/json',
                "Access-Control-Allow-Origin": "*",
                "Authorization": "Bearer " + sessionStorage.getItem('token')
            },
        })
            .then((response) => {
                // User registered successfully
                if (response.data['status'] === true) {
                    toast.success(response.data['message'])
                }
            })
            .catch((error) => {
                // console.log("Axios Error Occurred: " + error);
            })
    }

    // function to detect is object is empty or not
    function isEmptyObject(obj) {
        return JSON.stringify(obj) === '[]';
    }

    return (<div className="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab">
        {/* table title*/}
        <div className="table-title-area">
            <h3>Watch List</h3>
        </div>
        {/* Products */}
        <div className="row">
            {!isEmptyObject(products) ? products.map(props => {
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
                            <p>Bidding Price : <span><span>${props.minimum_bid}</span></span></p>
                            <div className="auction-card-bttm">
                                <Link href={`/auction/${props.title}`}><a className="eg-btn btn--primary btn--sm">Place
                                    a Bid</a></Link>
                                <div className="share-area">
                                    <div>
                                        <div className="share-btn" role='button'><i className='bx bxs-trash'
                                                                                    onClick={() => removeWatchList(props.prd_id)}/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            }) : (<>
                <h2>No Products found in your watchlist</h2>
            </>)}
        </div>
    </div>)
}

export default WatchList