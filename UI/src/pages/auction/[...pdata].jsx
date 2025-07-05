import React, {useEffect, useState} from "react";
import AuctionDetailsGallaryTab from "../../components/auctionDetails/AuctionDetailsGallaryTab";
import AuctionDetailsHistoryTab from "../../components/auctionDetails/AuctionDetailsHistoryTab";
import Layout from "../../components/layout/Layout";
import Router, {useRouter} from 'next/router'
import ReactStars from 'react-stars'
import {ToastContainer} from 'react-toastify';
import EndTimeCounter from "../../components/common/EndTimeCounter";


function AuctionDetailsPage() {
    const router = useRouter()
    const [product, setProduct] = useState([]);
    const [gallary, setGallary] = useState([]);
    const [amount, setAmount] = useState('');
    const [maxBidder, setMaxBidder] = useState('');
    const [productId, setProductId] = useState('');
    const [history, setHistory] = useState([]);
    const [isLoaded, setIsLoaded] = useState(true);
    const [bidConfirm, setBidConfirm] = useState(false);

    useEffect(() => {
        if (router.isReady) {
            let pid = router.query.pdata[0];
            if (!pid) {
                return undefined;
            } else {
                fetchProductData(pid).then(r => r);
                setProductId(pid);
                const getHistory = async (pid) => {
                    let headersList = {
                        "Accept": "*/*",
                        "Authorization": "Bearer " + sessionStorage.getItem('token')
                    }

                    let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/bidhistory?pid=${pid}`, {
                        method: "GET",
                        headers: headersList
                    });

                    let data = await response.json();
                    // console.log(data)
                    setHistory(data);
                };
                getHistory(pid).then(r => r);
            }
        }

        async function fetchProductData(id) {
            const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/products?product_id=${id}`);
            const data = await response.json();
            // console.log(data)
            setProduct(data);
            setGallary(data.images)
            // Fetching max Bidder
            await fetchMaxBidder(id)
        }

    }, [router.isReady, router.query, isLoaded])

    // Function to Fetch max Bidder
    async function fetchMaxBidder(id) {
        let bidder = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/get-highest-bidder?pid=${id}`);
        let bidder_name = await bidder.json();
        // console.log(bidder_name.max_bidder);
        setMaxBidder(bidder_name.max_bidder);
    }

    const PlaceBid = async (e) => {
        e.preventDefault();

        // If user confirms to place Bid 
        if (!bidConfirm) {
            return
        }

        if (sessionStorage.getItem('token') == null) {
            await Router.push('/login')
        }
        setIsLoaded(false);
        let headersList = {
            'Content-Type': 'application/json',
            "Access-Control-Allow-Origin": "*",
            "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let bodyContent = JSON.stringify({
            "pid": productId,
            "amount": amount,
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/bid`, {
            method: "POST",
            body: bodyContent,
            headers: headersList
        });

        let data = await response.json();
        // console.log(data);
        toast.success(data.msg)

        // fetching max bidder
        fetchMaxBidder(productId)

        setIsLoaded(true)
        setAmount('');
    }

    // confirm dialogue 
    const onConfirm = async () => {
        let result = confirm("Are you sure you want to place this bid?");
        // alert(result)
        setBidConfirm(result)
        if (result) {

        }

    };

    return (
        <Layout>
            <ToastContainer/>
            {/* <Breadcrumb pageName="Auction Details" pageTitle="Auction Details" /> */}
            <div className="auction-details-section pt-5 pb-120">
                <img alt="image" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-top"/>
                <img alt="image" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-bottom"/>
                <div className="px-2">
                    <div className="row g-2 mb-50">
                        <AuctionDetailsGallaryTab images={gallary}/>
                        <div className="col-xl-6 col-lg-5">
                            <div className="product-details-right  wow fadeInDown" data-wow-duration="1.5s"
                                 data-wow-delay=".2s">
                                <h3>{product.title}</h3>
                                <ReactStars value={product.condition_rating} size={30} count={6} edit={false}/>
                                <div className="bid-form">
                                    {/* <div className="form-title">
                                        <h5>Bid Now</h5>
                                    </div> */}
                                    <div className="auction-timer bg-white rounded">
                                        <div className="countdown p-3" id="timer1">
                                            <h4 className='text-danger text-center'>
                                                <EndTimeCounter product_id={productId}/>
                                            </h4>
                                        </div>
                                    </div>
                                    <form onSubmit={PlaceBid}>
                                        <div className="form-inner gap-2">
                                            <input type="number" className="form-control" min="1" value={amount}
                                                   placeholder="$00.00" onChange={(e) => {
                                                setAmount(Math.abs(e.target.value))
                                            }}/>
                                            <button className="btn--primary3 btn--sm" onClick={onConfirm}
                                                    type="submit">Place Bid
                                            </button>
                                        </div>
                                    </form>
                                    {/* <span className="text-danger mt-2"><pre className="d-inline">*</pre><b>Important Note</b> Please don&apos;t Place bid in last 5 Second</span> */}
                                </div>
                                <h4 className="mt-4">Retail Value: <span>${product.retail_value}</span></h4>
                                <h4 className="mt-4">Current Bid: <span
                                    className="text-danger">${product.current_bid}</span></h4>
                                <h6>SKU-Code : <span className="text-secondary">{product.sku}</span></h6>
                                <h6>Highest Bidder : <span className="text-secondary">{maxBidder}</span></h6>
                                <h6>Website: <span className="text-secondary"><a
                                    className="text-decoration-underline text-primary"
                                    href={product.website}>Visit now</a></span></h6>

                            </div>
                        </div>
                    </div>
                    <div className="row d-flex justify-content-center g-4">
                        <AuctionDetailsHistoryTab pid={productId} history={history} desc={product.condition_desc}
                                                  sku={product.sku} endtime={product.end_time}/>
                    </div>
                </div>
            </div>
        </Layout>
    );
}

export default AuctionDetailsPage;
