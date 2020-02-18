<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB; 
use cc\Quotation;

class piezaStrumis extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'contractdrawing';




    public function hello(){
    	return 'hello';
    }

    public static function pieza($idProyecto){
        return DB::connection('sqlsrv')->select("
            SELECT 
            distinct(ci.ContractItemID) as id,
            ci.Name as cod_elemento
            FROM
            ContractDrawing as cd
            inner join
            ContractListing as cl on cl.ContractListingID = cd.ContractListingID
            inner join
            Contract as ct on ct.ContractID = cl.ContractID
            inner join
            ContractMark as cmk on cmk.ContractDrawingID = cd.ContractDrawingID
            inner join
            ContractMarkItem as cmki on cmki.MarkID = cmk.MarkID
            inner join
            ContractItem as ci on ci.ContractListingID = cl.ContractListingID and ci.ContractItemID = cmki.ContractItemID
            inner join
            ContractMarkInstance as cmkin on cmkin.ContractListingID = cl.ContractListingID
            inner join
            item as i on i.ItemID = ci.ItemID
            inner join
            ContractMarkPhaseLot as cmpl on cmpl.ContractMarkPhaseLotID = cmkin.ContractMarkPhaseLotID
            inner join
            ContractLot as ctl on ctl.LotID = cmpl.LotID
            inner join
            ContractMarkItemInstance as cmii on cmii.ContractListingID = cl.ContractListingID and cmii.ContractMarkInstanceID = cmkin.ContractMarkInstanceID and cmii.ContractMarkItemID = cmki.MarkItemID
            WHERE
            ct.ContractID = ".$idProyecto."
            GROUP BY
            ci.Name, ci.ContractItemID, ct.Name
            ORDER BY
            cod_elemento asc;
            ");
    }

    public static function piezaMiscelaneos($idProyecto){
        return DB::connection('sqlsrv')->select("
            SELECT 
            distinct(ci.ContractItemID) as id,
            cmk.Name as cod_elemento
            FROM
            ContractDrawing as cd
            inner join
            ContractListing as cl on cl.ContractListingID = cd.ContractListingID
            inner join
            Contract as ct on ct.ContractID = cl.ContractID
            inner join
            ContractMark as cmk on cmk.ContractDrawingID = cd.ContractDrawingID
            inner join
            ContractMarkItem as cmki on cmki.MarkID = cmk.MarkID
            inner join
            ContractItem as ci on ci.ContractListingID = cl.ContractListingID and ci.ContractItemID = cmki.ContractItemID
            inner join
            ContractMarkInstance as cmkin on cmkin.ContractListingID = cl.ContractListingID
            inner join
            item as i on i.ItemID = ci.ItemID
            inner join
            ContractMarkPhaseLot as cmpl on cmpl.ContractMarkPhaseLotID = cmkin.ContractMarkPhaseLotID
            inner join
            ContractLot as ctl on ctl.LotID = cmpl.LotID
            inner join
            ContractMarkItemInstance as cmii on cmii.ContractListingID = cl.ContractListingID and cmii.ContractMarkInstanceID = cmkin.ContractMarkInstanceID and cmii.ContractMarkItemID = cmki.MarkItemID
            WHERE
            ct.ContractID = ".$idProyecto."
            GROUP BY
            cmk.Name, ci.ContractItemID
            ORDER BY
            cod_elemento asc;
            ");
    }

    public static function piezaArmado($idProyecto){
        return DB::connection('sqlsrv')->select("
            SELECT
            cmk.Name as marca,cmk1.MarkID as id, cmk.quantity as cantidad from
            ContractDrawing as cd
            inner join
            ContractListing as cl on cl.ContractListingID = cd.ContractListingID
            inner join
            Contract as ct on ct.ContractID = cl.ContractID
            inner join
            ContractMark as cmk on cmk.ContractDrawingID = cd.ContractDrawingID
            inner join
            ContractMarkItem as cmki on cmki.MarkID = cmk.MarkID
            inner join
            ContractItem as ci on ci.ContractListingID = cl.ContractListingID and ci.ContractItemID = cmki.ContractItemID
            inner join
            ContractMarkInstance as cmkin on cmkin.ContractListingID = cl.ContractListingID
            inner join
            item as i on i.ItemID = ci.ItemID
            inner join
            ContractMarkPhaseLot as cmpl on cmpl.ContractMarkPhaseLotID = cmkin.ContractMarkPhaseLotID
            inner join
            ContractLot as ctl on ctl.LotID = cmpl.LotID
            inner join
            ContractMarkItemInstance as cmii on cmii.ContractListingID = cl.ContractListingID and cmii.ContractMarkInstanceID = cmkin.ContractMarkInstanceID and cmii.ContractMarkItemID = cmki.MarkItemID
            left join ContractMark as cmk1 on cmk1.MarkID = cmk.MarkID
            WHERE
            ct.ContractID = ".$idProyecto."
            GROUP BY
            cmk.Name,cmk.Quantity, cmk1.MarkID
            ORDER BY
            cmk.Name;
            ");
    }

    public static function getInfo($pieza){
        return DB::connection('sqlsrv')->select("select cmk.Name as nombre from ContractMark as cmk where cmk.MarkID = ".$pieza.";");
    }

     public static function armadoGetCantidadStrumis($idProyecto){
        $cantidad =  DB::connection('sqlsrv')->select("select cmk.quantity as cantidad from ContractMark as cmk where cmk.MarkID = ".$idProyecto.";");
        return $cantidad;
    }

    public static function cantidadPiezaProd($idPieza){
        return DB::connection('sqlsrv')->select("
            SELECT
            cmk.Quantity as cantidad
            FROM
            ContractDrawing as cd
            inner join
            ContractListing as cl on cl.ContractListingID = cd.ContractListingID
            inner join
            Contract as ct on ct.ContractID = cl.ContractID
            inner join
            ContractMark as cmk on cmk.ContractDrawingID = cd.ContractDrawingID
            inner join
            ContractMarkItem as cmki on cmki.MarkID = cmk.MarkID
            inner join
            ContractItem as ci on ci.ContractListingID = cl.ContractListingID and ci.ContractItemID = cmki.ContractItemID
            inner join
            ContractMarkInstance as cmkin on cmkin.ContractListingID = cl.ContractListingID
            inner join
            item as i on i.ItemID = ci.ItemID
            inner join
            ContractMarkPhaseLot as cmpl on cmpl.ContractMarkPhaseLotID = cmkin.ContractMarkPhaseLotID
            inner join
            ContractLot as ctl on ctl.LotID = cmpl.LotID
            inner join
            ContractMarkItemInstance as cmii on cmii.ContractListingID = cl.ContractListingID and cmii.ContractMarkInstanceID = cmkin.ContractMarkInstanceID and cmii.ContractMarkItemID = cmki.MarkItemID
            WHERE
            cmk.Name = '".substr($idPieza, 1)."'
            GROUP BY
            cmk.Name,cmk.Quantity,cmk.MarkID
            ORDER BY
            cmk.Name;
            ");
    }

    public static function cantidad($idProyecto, $idPieza){
        return DB::connection('sqlsrv')->select("
            select 
            count(ci.name) as CANTIDAD 
            from 
            ContractDrawing as cd 
            inner join ContractListing as cl on cl.ContractListingID = cd.ContractListingID 
            inner join Contract as ct on ct.ContractID = cl.ContractID 
            inner join ContractMark as cmk on cmk.ContractDrawingID = cd.ContractDrawingID 
            inner join ContractMarkItem as cmki on cmki.MarkID = cmk.MarkID 
            inner join ContractItem as ci on ci.ContractListingID = cl.ContractListingID and ci.ContractItemID = cmki.ContractItemID 
            inner join ContractMarkInstance as cmkin on cmkin.ContractListingID = cl.ContractListingID 
            inner join item as i on i.ItemID = ci.ItemID 
            inner join ContractMarkPhaseLot as cmpl on cmpl.ContractMarkPhaseLotID = cmkin.ContractMarkPhaseLotID 
            inner join ContractLot as ctl on ctl.LotID = cmpl.LotID 
            inner join ContractMarkItemInstance as cmii on cmii.ContractListingID = cl.ContractListingID and cmii.ContractMarkInstanceID = cmkin.ContractMarkInstanceID and cmii.ContractMarkItemID = cmki.MarkItemID 
            where ci.ContractItemID = '".$idPieza."' group by ci.Name;
            ");
            /*SELECT
            COUNT(ci.Name) as CANTIDAD
            FROM
            ContractDrawing as cd
            inner join
            ContractListing as cl on cl.ContractListingID = cd.ContractListingID
            inner join
            Contract as ct on ct.ContractID = cl.ContractID
            inner join
            ContractMark as cmk on cmk.ContractDrawingID = cd.ContractDrawingID
            inner join
            ContractMarkItem as cmki on cmki.MarkID = cmk.MarkID
            inner join
            ContractItem as ci on ci.ContractListingID = cl.ContractListingID and ci.ContractItemID = cmki.ContractItemID
            inner join
            ContractMarkInstance as cmkin on cmkin.ContractListingID = cl.ContractListingID
            inner join
            item as i on i.ItemID = ci.ItemID
            inner join
            ContractMarkPhaseLot as cmpl on cmpl.ContractMarkPhaseLotID = cmkin.ContractMarkPhaseLotID
            inner join
            ContractLot as ctl on ctl.LotID = cmpl.LotID
            inner join
            ContractMarkItemInstance as cmii on cmii.ContractListingID = cl.ContractListingID and cmii.ContractMarkInstanceID = cmkin.ContractMarkInstanceID and cmii.ContractMarkItemID = cmki.MarkItemID
            WHERE
            ci.ContractItemID = ".$idPieza."
            GROUP BY
            ci.Name  */
        }

        public static function elementosPrincipales($idProyecto){
            return DB::connection('sqlsrv')->select("
                select
                distinct(ci.ContractItemID) as id, 
                ci.Name as cod_elemento,
                cmki.MainMember
                from
                ContractDrawing as cd
                inner join
                ContractListing as cl on cl.ContractListingID = cd.ContractListingID
                inner join
                Contract as ct on ct.ContractID = cl.ContractID
                inner join
                ContractMark as cmk on cmk.ContractDrawingID = cd.ContractDrawingID
                inner join
                ContractMarkItem as cmki on cmki.MarkID = cmk.MarkID
                inner join
                ContractItem as ci on ci.ContractListingID = cl.ContractListingID and ci.ContractItemID = cmki.ContractItemID
                inner join
                ContractMarkInstance as cmkin on cmkin.ContractListingID = cl.ContractListingID
                inner join
                item as i on i.ItemID = ci.ItemID
                inner join
                ContractMarkPhaseLot as cmpl on cmpl.ContractMarkPhaseLotID = cmkin.ContractMarkPhaseLotID
                inner join
                ContractLot as ctl on ctl.LotID = cmpl.LotID
                inner join
                ContractMarkItemInstance as cmii on cmii.ContractListingID = cl.ContractListingID and cmii.ContractMarkInstanceID = cmkin.ContractMarkInstanceID and cmii.ContractMarkItemID = cmki.MarkItemID
                WHERE
                ct.ContractID = ".$idProyecto." and cmki.MainMember = 1
                group by 
                ci.Name, ci.ContractItemID, cmki.MainMember
                order by
                cod_elemento asc;
                ");
        }

        public static function getNombre($proyecto, $pieza){
            $nombre = DB::connection('sqlsrv')->table('ContractMark')->select('Name')->where('MarkID','=',$pieza)->value('Name');
            return $nombre;
        }


    }
