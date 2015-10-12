# Magento-InventoryLog
Magento Module to keep track of the stock changes in products

  - Uses upgrade scripts for the needed entity/entities
  - Each time the stock quantity of a product changes, stores the value and the variation in
the table along with the timestamp and some informations about the action (if it was
triggered by an admin user, by the APIs or by a purchase)
  - Adds a page in the admin, configured with proper ACLs, that allows to see the stored
  - informations - filterable by product sku

The sku is deliberately not saved in the entity since can change over the time. This is later on joined from the catalog/product model.

Todo
integration with ModMan
track the product stocks after an import
