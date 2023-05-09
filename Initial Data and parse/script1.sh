CREATE TABLE tblItems(
	ItemID int NOT NULL,
	Name varchar,
	Currently double,
	First_bid double,
	Number_of_Bids int,
	Location varchar,
	Country varchar,
	Started Date,
	Ends Date,
	Seller varchar NOT NULL,
	Description varchar
);

CREATE TABLE tblBids(
	BidderID varchar NOT NULL,
	BidderRating int,
	BidderLocation varchar,
	BidderCountry varchar,
	BidTime Date,
	BidAmount double,
	ItemID int NOT NULL
);

CREATE TABLE tblUsers(
	Seller varchar,
	SellerRating int
);

CREATE TABLE tblCategory(
	ItemID int,
	Category varchar
);

.mode CSV
.import itemData.csv tblItems
.import BidderData.csv tblBids
.import SellerData.csv tblUsers
.import CategoryData.csv tblCategory;

