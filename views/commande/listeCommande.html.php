    <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <h1 class="text-3xl font-bold text-gray-800">Liste des Commandes</h1>
    <div class="flex items-center gap-4 w-full md:w-auto">
        <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">Vendeur: <?= $_SESSION['user']->getPrenom() ?? 'Indefined' ?> <?= $_SESSION['user']->getNom() ?? 'Indefined' ?></span>
        <!-- Bouton pour ouvrir le modal -->
        <button onclick="document.getElementById('add-order-modal').showModal()" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full px-4 py-2 text-sm font-medium hover:opacity-90 transition-opacity">
            <i class="fas fa-plus mr-2"></i>Nouveau
        </button>
    </div>
</div>

<!-- Modal d'ajout de commande -->
<dialog id="add-order-modal" class="modal backdrop-blur-sm">
    <div class="modal-box max-w-3xl p-0 overflow-visible">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-t-lg">
            <h3 class="text-xl font-bold text-white">Nouvelle Commande</h3>
        </div>
        
        <form method="dialog" class="absolute right-2 top-2">
            <button class="btn btn-sm btn-circle bg-white text-gray-600 hover:bg-gray-100 border-none">
                ✕
            </button>
        </form>
        
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 space-x-8">
                <!-- Client -->
              <form method="get" action="" class="flex space-x-2">
                <input type="hidden" name="open_modal" value="1">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                    <input type="search" name="tel_client" placeholder="telephone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white mt-6 rounded-full px-4 py-2 text-sm font-medium hover:opacity-90 transition-opacity">
                        Rechercher
                    </button>
                </div>
            </form>


              <div class="flex items-center mt-3">
                <?php if ($client !== null): ?>
                    <span><?= $client->getNom() ?></span>
                <?php endif; ?>
              </div>
            </div>
            
            <!-- Liste des produits -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-gray-800">Produits</h4>
                
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Produit</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Quantité</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Prix</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Ligne produit -->
                            <tr>
                                <td class="px-4 py-3">
                                    <select class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="" disabled selected>Sélectionner</option>
                                        <option value="1">Produit A</option>
                                        <option value="2">Produit B</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number" min="1" value="1" class="w-20 px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" value="€0.00" class="w-24 px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500" readonly>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-medium">€0.00</span>
                                </td>
                                <td class="px-4 py-3">
                                    <button type="button" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="p-3 bg-gray-50 border-t border-gray-200">
                        <button type="button" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i> Ajouter un produit
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Total et Remarques -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                    <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total:</span>
                        <span class="font-medium">€0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Remise:</span>
                        <span class="font-medium">€0.00</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-2">
                        <span class="text-gray-800 font-semibold">Total:</span>
                        <span class="text-blue-600 font-bold">€0.00</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end p-6 bg-gray-50 rounded-b-lg space-x-3">
            <button type="button" onclick="document.getElementById('add-order-modal').close()" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Annuler
            </button>
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                Enregistrer la commande
            </button>
        </div>
    </div>
    
    <!-- Fermer le modal en cliquant à l'extérieur -->
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

            <!-- Filters and Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                <form action="<?= $_ENV['WEB_ROOT'] ?>/accueil" method="GET" class="space-y-4 md:space-y-0">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Client Filter -->
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Nom du client</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="client_search" placeholder="Rechercher..." 
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Date Filter -->
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="Date_search" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Order Number Filter -->
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">N° Commande</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                </div>
                                <input type="text" name="search" placeholder="Numéro..." 
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit" class="h-10 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2 w-full">
                                <i class="fas fa-filter"></i>
                                <span>Filtrer</span>
                            </button>
                            <a href="<?= $_ENV['WEB_ROOT'] ?>/accueil" class="h-10 px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center justify-center">
                                <i class="ri-loop-right-line"></i>
                            </a>
                            
                        </div>
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Commande</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($commandes)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Aucune commande trouvée
                                    </td>
                                </tr>
                            <?php else: ?>
                            <?php foreach ($commandes as $commande): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-blue-600"><?= $commande->getNumero() ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-medium"><?= substr($commande->getClient()->getNom(), 0, 1) . substr($commande->getClient()->getPrenom(), 0, 1) ?></span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($commande->getClient()->getNom() . ' ' . htmlspecialchars($commande->getClient()->getPrenom())) ?></div>
                                            <div class="text-sm text-gray-500"><?= htmlspecialchars($commande->getClient()->getEmail())?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= date('d/m/Y', strtotime($commande->getDate())) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= number_format($commande->getMontant(), 2, ',', ' ') ?> €</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php 
                                    $statusColor = [
                                        'paye' => 'green',
                                        'impaye' => 'red'
                                    ];
                                    $color = $statusColor[strtolower($commande->getStatut())] ?? 'blue';
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?= $color ?>-100 text-<?= $color ?>-800">
                                        <?= htmlspecialchars($commande->getStatut())?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <button class="text-blue-600 hover:text-blue-900 transition" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 transition" title="Facture">
                                            <i class="fas fa-file-invoice"></i>
                                        </button>
                                        <button class="text-purple-600 hover:text-purple-900 transition" title="Paiement">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Précédent
                        </a>
                        <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Suivant
                        </a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Affichage de <span class="font-medium">1</span> à <span class="font-medium"><?= min(3, count($commandes)) ?></span> sur <span class="font-medium"><?= count($commandes) ?></span> résultats
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Précédent</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="#" aria-current="page" class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    1
                                </a>
                              
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Suivant</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
  window.addEventListener('DOMContentLoaded', () => {
    <?php if (!empty($openModal)): ?>
      document.getElementById('add-order-modal').showModal();
    <?php endif; ?>
  });
</script>
