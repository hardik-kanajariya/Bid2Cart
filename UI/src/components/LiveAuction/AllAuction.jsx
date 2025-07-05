import React, {useEffect, useState} from 'react'
import Counter from '../common/Counter';
import Link from 'next/link';
import ReactStars from 'react-stars';
import Image from 'next/image';
import Zoom from 'react-reveal/Zoom';
import ReactPaginate from 'react-paginate';
import Preloader from '../common/Preloader';
import {ToastContainer, toast} from 'react-toastify';
import Router from "next/router";

function AllAuction({item, category, totalProducts}, props) {
    const [products, setProducts] = useState([]);
    const [pageCount, setPageCount] = useState(0);
    const [isLoaded, setIsLoaded] = useState(false)
    const [productId, setProductId] = useState('');
    const [amount, setAmount] = useState([]);
    const [bidConfirm, setBidConfirm] = useState(false);
    const [watchlistIds, setWatchlistIds] = useState([]);
    const [bidInsert, setBidInsert] = useState([]);

    useEffect(() => {
        // alert(category)
        setProducts(item);
        setPageCount(Math.ceil(totalProducts / 12))

        // Fetching watchlist
        const getWatchlist = async () => {
            let headersList = {
                "Accept": "*/*", "Authorization": "Bearer " + sessionStorage.getItem('token'),
            }

            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/watchlist/ids`, {
                method: "GET", headers: headersList
            });

            let data = await response.json();
            console.log(data)
            setWatchlistIds(data)
            setIsLoaded(false)
        }
        getWatchlist().then(r => setIsLoaded(false));

    }, [item, totalProducts])

    // Function to add product to watch list
    async function addWatchList(id) {
        // validating if user is logged in or not
        if (!sessionStorage.getItem('token')) {
            await Router.push('/login')
            toast.success("Please Login to add product into your watchlist")
            return 0;
        }

        // using Fetch API
        let headersList = {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let bodyContent = JSON.stringify({
            "pid": id,
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/add/watchlist`, {
            method: "POST", body: bodyContent, headers: headersList
        });

        let data = await response.json();
        // console.log(data);
        toast.success(data.message)
    }

    // Custom image loader
    const customImageLoader = ({src}) => {
        return src;
    }

    // Checking Products is empty or not
    function isEmptyObject(obj) {
        return JSON.stringify(obj) === '[]';
    }

    // Handle Pagination
    const handlePageChange = (data) => {
        console.log(data.selected)
        const current_page = data.selected + 1;
        const getAllProducts = async () => {
            const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/products/all?page=${current_page}`);
            const data = await res.json()
            setProducts(data.data)
        }
        getAllProducts().then(r => setIsLoaded(false));
    }

    // Function to get confirmation from user 
    const onConfirm = async () => {
        try {
            if (!confirm(`Are you sure you want to place bid of ${amount[0].amount}?`)) {
                return
            }
            // Placing Bid if user confirms 
            await placeBid();
        } catch (ex) {
            toast.error("Please Enter Amount to continue")
        }
    };

    // Function to place Bid 
    async function placeBid() {
        // If user confirms to place Bid 

        if (amount[0].amount === '') {
            toast.error("Oops! Something went wrong please try again :)")
            return
        }

        if (sessionStorage.getItem('token') == null) {
            await Router.push('/login')
        }

        let headersList = {
            'Content-Type': 'application/json',
            "Access-Control-Allow-Origin": "*",
            "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let bodyContent = JSON.stringify({
            "pid": amount[0].id, "amount": amount[0].amount,
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/bid`, {
            method: "POST", body: bodyContent, headers: headersList
        });

        let data = await response.json();
        toast.success(data.msg)
        setAmount([]);
        const getAllProducts = async () => {
            const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/products/all`);
            const data = await res.json()
            setProducts(data.data)
        }
        await getAllProducts();
    }

    // Function to detect Expired Auction
    function isExpired(date) {
        let now = new Date();
        let end = new Date(date);
        return end < now;
    }

    return <>
        {isLoaded ? (<Preloader classText="preloader"/>) : (<>
                <ToastContainer/>
                <div className="row gy-4 d-flex justify-content-center">
                    <div className="row  d-flex justify-content-center"></div>
                    {products && products.map(props => {
                        return ( isExpired(props.end_time) ? '' :<div key={props.prd_id} className="col-lg-4 col-md-6 col-sm-12">
                                <Zoom ssrFadeout cascade>
                                    <div data-wow-duration="1.5s" data-wow-delay="0.2s"
                                         className="eg-card auction-card wow animate fadeInDown">
                                        {/* creating premium product tag */}
                                        <div class="dealwrapper red">
                                            {props.is_featured === 1 ? <div class="ribbon-wrapper">
                                                <div class="ribbon-tag">Featured</div>
                                            </div> : ''}
                                            <Link href={`/auction/${props.prd_id}/${props.title}`}>
                                                <a>
                                                    <div className="auction-img">
                                                        <Image loader={customImageLoader} alt="image"
                                                               src={props.thumbnail}
                                                               width={500} height={500}/>
                                                        <div className="auction-timer shadow-sm">
                                                            <div className="countdown" id="timer1">
                                                                <h4><Counter formate="counter3" date={props.end_time}/>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </Link>
                                        </div>
                                        <div className="auction-content">
                                            <ReactStars value={props.condition_rating} size={20} count={6}
                                                        edit={false}/>
                                            <h4><Link
                                                href={`/auction/${props.prd_id}/${props.title}`}><a>{props.title}</a></Link>
                                            </h4>
                                            <p>Bidding Price : <span><span>${props.current_bid}</span></span></p>
                                            <div className="auction-card-bttm">
                                                <input id={props.prd_id} className='form-control' min="1" type="number"
                                                       style={{
                                                           width: "100px", padding: "5px"
                                                       }} onChange={(e) => {
                                                    setAmount([{"id": props.prd_id, "amount": Math.abs(e.target.value)}])

                                                }} value={amount.amount}/>
                                                <a className="eg-btn btn--primary btn--sm" onClick={onConfirm}>Place a
                                                    Bid</a>
                                                <div className="share-area">
                                                    <div>
                                                        <div className="share-btn" role='button'>
                                                            <i className={watchlistIds.indexOf(props.prd_id) > -1 ? "bx bx-sm bx-heart-circle bg-danger text-white" : "bx bx-sm bx-heart-circle"}
                                                               onClick={() => addWatchList(props.prd_id)}/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </Zoom>
                            </div>)
                    })}
                    {isEmptyObject(products) ? (<h2>No Products Found</h2>) : ''}

                    {/* Pagination */}
                    <ReactPaginate
                        breakLabel="..."
                        nextLabel=">>"
                        pageCount={pageCount}
                        pageRangeDisplayed={3}
                        marginPagesDisplayed={2}
                        previousLabel="<<"
                        onPageChange={handlePageChange}
                        renderOnZeroPageCount={null}
                        containerClassName={'pagination justify-content-center'}
                        pageClassName={'page-item'}
                        pageLinkClassName={'page-link'}
                        previousClassName={'page-item'}
                        previousLinkClassName={'page-link'}
                        nextClassName={'page-item'}
                        nextLinkClassName={'page-link'}
                        activeClassName={'active'}
                        breakLinkClassName={'page-link'}
                    />
                </div>
            </>)}
    </>
}

export default AllAuction
