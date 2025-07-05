import React, {useEffect, useState} from "react";
import {useRouter} from 'next/router'
import Layout from "../../components/layout/Layout";
import AllAuction from "../../components/LiveAuction/AllAuction";
import Preloader from "../../components/common/Preloader";
import SideBar from "../../components/SideBar/SideBar";

function ProductsByCategory(props) {
    const [isLoaded, setIsLoaded] = useState(true);
    const [products, setProducts] = useState([])
    const router = useRouter()
    useEffect(() => {
        const {cname} = router.query
        const getAllProductsByCategory = async () => {
            let headersList = {
                "Accept": "application/json",
                "Content-Type": "application/json"
            }

            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/category/product?category=${cname}`, {
                method: "GET",
                headers: headersList
            });

            let data = await response.json();
            // console.log(data);

            setProducts(data.data)
            setIsLoaded(false)
        }
        getAllProductsByCategory().then(r => setIsLoaded(false));
    }, [router.query])

    // Function to Handle Filter
    async function handleFilter(value) {
        const getProductsByFilter = async (term) => {
            const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/products/filter?term=${term}`);
            const data = await res.json();
            setProducts(data.data);
            setIsLoaded(false)
        }
        await getProductsByFilter(value);
    }

    // Function to get search result
    async function search(e, term) {
        setIsLoaded(true)
        e.preventDefault();
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/search?term=${term}`);
        const data = await res.json();
        setProducts(data.data);
        setIsLoaded(false)
    }

    // Function to Products by category
    async function getCategoryData(category) {
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/category/product?category=${category}`);
        const data = await res.json();
        setProducts(data.data);

    }

    // Function to get MyBids
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

    // Function to get my watchlist
    async function getMyWatchList() {
        let headersList = {
            "Accept": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/watchlist`, {
            method: "GET",
            headers: headersList
        });

        let data = await response.json();
        setProducts(data);
    }

    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (<>
                <Layout>
                    <div className="live-auction-section pt-3 pb-120">
                        <img alt="image" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-top"/>
                        <img alt="image" src="/assets/images/bg/section-bg.png"
                             className="img-fluid section-bg-bottom"/>
                        <div className="row sidebar-reverse">
                            {/* SideBar */}
                            <SideBar handleFilter={handleFilter} getCategory={getCategoryData}
                                     getMyWatchList={getMyWatchList} getMyBids={getMyBids} searchProduct={search}/>
                            <div className="col-md-9 mt-5">
                                <AllAuction item={products}/>
                            </div>
                        </div>
                    </div>
                </Layout>
            </>)}
        </>
    );
}

export default ProductsByCategory;

{/* <>
      {isLoaded ? (
        <Preloader classText="preloader" />
      ) : (<> </>)}
    </> */
}