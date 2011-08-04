#
# Table structure for table 'tx_quickshop_products'
#
CREATE TABLE tx_quickshop_products (
	in_stock int(11) DEFAULT '0' NOT NULL
	exclude_from_stock tinyint(3) DEFAULT '0' NOT NULL
);